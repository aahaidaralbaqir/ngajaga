<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(Request $request) {
        $data['page_title'] = 'Supplier';
        $suppliers = DB::table('suppliers')->get();
        $data['suppliers'] = $suppliers;
        $data['total_row'] = count($suppliers);
        $data['suppliers'] = DB::table('suppliers')->get();
        return view('admin.supplier.index', $data);
    }

    public function createForm(Request $request) {
        $data['page_title'] = 'Menambahkan Supplier';
        $data['target_route'] = 'supplier.create';
        $data['item'] = NULL;
        return view('admin.supplier.form', $data);
    }

    public function editForm(Request $request, $supplierId) {
        $current_record = DB::table('suppliers')->where('id', $supplierId)->first();
        if (!$current_record) {
            return redirect()
                ->route('supplier.index')
                ->with([
                    'error' => 'Supplier tidak ditemukan'
                ]);
        }
        $data['target_route'] = 'supplier.edit';
        $data['item'] = $current_record;
        return view('admin.supplier.form', $data);
    }

    public function edit(Request $request) {
        $supplier_id = $request->input('id');
        $current_record = DB::table('suppliers')->where('id', $supplier_id)->first();
        if (!$current_record) {
            return redirect()
                ->route('supplier.index')
                ->with([
                    'error' => 'Supplier tidak ditemukan'
                ]);
        }

        $user_input_field_rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'address' => 'required'
        ];

        $user_input = $request->only('name', 'email', 'phone_number', 'address');
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return redirect()
                ->route('supplier.edit.form')
                ->withErrors($validator)
                ->withInput();
        }

        DB::table('suppliers')->where('id', $supplier_id)->update($user_input);
        return redirect()
            ->route('supplier.index')
            ->with([
                'success' => 'Supplier berhasil diubah'
            ]);
    }

    public function create(Request $request) {
        $user_input_field_rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'address' => 'required'
        ];

        $user_input = $request->only('name', 'email', 'phone_number', 'address');
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return redirect()
                ->route('supplier.create.form')
                ->withErrors($validator)
                ->withInput();
        }

        DB::table('suppliers')->insert($user_input);
        return redirect()
            ->route('supplier.index')
            ->with([
                'success' => 'Berhasil menambahkan supplier'
            ]);
    }
}
