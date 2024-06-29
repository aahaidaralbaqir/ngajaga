<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Repositories\AccountRepository;
use App\Repositories\DebtRepository;
use App\Repositories\TransactionRepository;
use App\Util\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DebtController extends Controller
{
    public function getDebts(Request $request)
    {
        $debt_records = DebtRepository::getDebts($request->all());
        $debt_ids = array_map(function ($item) {
            return $item->id;
        }, $debt_records->toArray());
        $receivable_records = DebtRepository::getReceivableByDebtIds($debt_ids);
        $receivable_amount_by_debt_ids = [];
        foreach ($receivable_records as $record) {
            if (array_key_exists($record->debt_id, $receivable_amount_by_debt_ids)) {
                continue;
            }
            $receivable_amount_by_debt_ids[$record->debt_id] = $record->receivable_amount;
        }

        foreach ($debt_records as $index => $debt) {
            $receivable_amount = 0;
            if (array_key_exists($debt->id, $receivable_amount_by_debt_ids)) {
                $receivable_amount = $receivable_amount_by_debt_ids[$debt->id];
            }

            $debt->receivable_amount = $receivable_amount;
            $debt_records[$index] = $debt;
        }
        return view('admin.debt.index')
            ->with('debts', $debt_records)
            ->with('has_filter', $request->query->count() > 0)
            ->with('user', parent::getUser());
    }

    public function createDebtForm(Request $request)
    {
        $transaction_records = TransactionRepository::getPaidTransaction();
        return view('admin.debt.form')
            ->with('transactions', $transaction_records)
            ->with('target_route', 'create.debt')
            ->with('page_title', 'Menambahkan kasbon baru')
            ->with('user', parent::getUser())
            ->with('item', NULL);
    }

    public function editDebtForm(Request $request, $debtId)
    {
        $debt_record = DebtRepository::getDebtById($debtId);
        $transaction_records = TransactionRepository::getPaidTransaction();
        if (!$debt_record) {
            return Response::backWithError('Kasbon tidak ditemukan');
        }
        return view('admin.debt.form')
            ->with('target_route', 'edit.debt')
            ->with('transactions', $transaction_records)
            ->with('page_title', 'Mengubah kasbon')
            ->with('user', parent::getUser())
            ->with('item', $debt_record);
    }

    public function createDebt(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_input = $request->only('transaction_id', 'amount');
            $user_input_field_rules = [
                'transaction_id' => 'required|exists:transactions,id',
                'amount'         => 'required|min:1'];
            
            $validator = Validator::make($user_input, $user_input_field_rules);
            if ($validator->fails()) {
                return Response::backWithErrors($validator);
            }
            $debt_transaction_record = DebtRepository::getDebtByTransasction($user_input['transaction_id']);
            if ($debt_transaction_record) {
                return Response::backWithError('Tidak bisa menambahkan hutang terhadap transaksi tersebut');
            }
            $transaction_record = TransactionRepository::getTransactionById($user_input['transaction_id']);
            if ($user_input['amount'] > $transaction_record->price_total) {
                return Response::backWithError('Nominal hutang tidak boleh lebih dari nilai transaksi');
            }

            $user_input['created_by'] = parent::getUserId();
            $debt_id = DebtRepository::createDebt($user_input);

            $create_cashflow_record = [
                'account_id'    => $transaction_record->account_id,
                'amount'        => $user_input['amount'] * -1,
                'created_by'    => parent::getUserId(),
                'cashflow_type' => Constant::CashflowDebt,
                'identifier'    => $debt_id,
                'description'   => 'Pengurangan saldo karena transaksi '. $transaction_record->order_id .' menggunakan kasbon ' . $debt_id
            ];
            AccountRepository::createCashflow($create_cashflow_record);
            DB::commit();
            return Response::redirectWithSuccess('debt.index', 'Berhasil menambahkan kasbon baru');
        } catch (Exception $error) {
            DB::rollBack();
            return Response::backWithError('Gagal menambahkan kasbon baru ' . $error->getMessage()); 
        }
        
    }

    public function editDebt(Request $request)
    {
        DB::beginTransaction();
        try {
            $debt_id = $request->input('id');
            $debt_record = DebtRepository::getDebtById($debt_id);
            if (!$debt_record) {
                return Response::backWithError('Kasbon tidak ditemukan');
            }

            $user_input = $request->only('transaction_id', 'amount');
            if ($debt_record->transaction_id != $user_input['transaction_id']) {
                $transaction_record = DebtRepository::getDebtByTransasction($user_input['transaction_id']);
                if ($transaction_record) {
                    return Response::backWithError('Tidak bisa menambahkan hutang karena transaksi sudah digunakan');
                } 
            }

            $transaction_record = TransactionRepository::getTransactionById($user_input['transaction_id']);
            if ($user_input['amount'] > $transaction_record->price_total) {
                return Response::backWithError('Nominal hutang tidak boleh lebih dari nilai transaksi');
            }

            AccountRepository::deleteCashflowByDebtId($debt_id);

            $create_cashflow_record = [
                'account_id'    => $transaction_record->account_id,
                'amount'        => $user_input['amount'] * -1,
                'created_by'    => parent::getUserId(),
                'cashflow_type' => Constant::CashflowDebt,
                'identifier'    => $debt_id,
                'description'   => 'Pengurangan saldo karena transaksi '. $transaction_record->order_id .' menggunakan kasbon ' . $debt_id
            ];
            AccountRepository::createCashflow($create_cashflow_record);

            DebtRepository::updateDebt($debt_id, $user_input);
            DB::commit();
            return Response::redirectWithSuccess('debt.index', 'Kasbon berhasil diubah');
        } catch (Exception $error) {
            DB::rollBack();
            return Response::backWithError('Gagal mengubah kasbon ' . $error->getMessage());  
        }
        
    }

    public function getReceivable(Request $request, $debtId)
    {
        $debt_record = DebtRepository::getDebtById($debtId);
        if (!$debt_record) {
            return Response::backWithError('Data kasbon tidak ditemukan');
        }

        $receivable_records = DebtRepository::getReceivableByDebtId($debtId);
        return view('admin.receivable.index')
            ->with('debt_record', $debt_record)
            ->with('receivable_records', $receivable_records)
            ->with('user', parent::getUser());
    }

    public function createReceivableForm(Request $request, $debtId)
    {
        $debt_record = DebtRepository::getDebtById($debtId);
        if (!$debt_record) {
            return Response::backWithError('Data kasbon tidak ditemukan');
        }

        return view('admin.receivable.form')
            ->with('debt_record', $debt_record)
            ->with('target_route', 'receivable.create')
            ->with('page_title', 'Menambahkan data pembayaran kasbon')
            ->with('user', parent::getUser());
    }

    public function createReceivable(Request $request)
    {
        $user_input = $request->only('debt_id', 'amount', 'receivable_date');
        $user_input_field_rules = [
            'debt_id'           => 'required|exists:debt,id',
            'receivable_date'   => 'required|date_format:Y-m-d',
            'amount'            => 'required|min:1'];
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return Response::backWithErrors($validator);
        }

        $user_input['created_by'] = parent::getUserId();
        $user_input['receivable_date'] = strtotime($user_input['receivable_date']);
        DebtRepository::createReceivable($user_input);
        return redirect()
            ->route('receivable.index', ['debtId' => $user_input['debt_id']])
            ->with(['success' => 'Data pembayaran kasbon berhasil disimpan']);
    }

    public function editReceivableForm(Request $request, $receivableId)
    {
        $receiveable_record = DebtRepository::getReceivableById($receivableId);
        if (!$receiveable_record) {
            return Response::backWithError('Data pembayaran kasbon tidak ditemukan');
        }

        $debt_record = DebtRepository::getDebtById($receiveable_record->debt_id);
        if (!$debt_record) {
            return Response::backWithError('Data kasbon tidak ditemukan');
        }


        return view('admin.receivable.form')
            ->with('item', $receiveable_record)
            ->with('user', parent::getUser())
            ->with('target_route', 'receivable.edit')
            ->with('page_title', 'Mengubah data pembayaran kasbon');
    }

    public function editReceiveable(Request $request)
    {
        $receivable_id = $request->input('id');
       
        $receiveable_record = DebtRepository::getReceivableById($receivable_id);
        if (!$receiveable_record) {
            return Response::backWithError('Data pembayaran kasbon tidak ditemukan');
        }

        $user_input = $request->only('debt_id', 'amount');
        $user_input_field_rules = [
            'debt_id'   => 'required|exists:debt,id',
            'amount'    => 'required|min:1'];
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return Response::backWithErrors($validator);
        }

        $user_input['created_by'] = parent::getUserId();
        DebtRepository::updateReceivable($receivable_id, $user_input);
        return redirect()
            ->route('receivable.index', ['debtId' => $user_input['debt_id']])
            ->with(['success' => 'Data pembayaran kasbon berhasil ubah']);
    }
}
