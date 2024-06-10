<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product_records = DB::table('products')
                            ->select(['products.id', 'products.name', 'products.selling_price', DB::raw('category.name AS category_name'), DB::raw('shelf.name AS shelf_name')])
                            ->leftJoin('category', function ($join) {
                                $join->on('category.id', '=', 'products.category_id');
                            })
                            ->leftJoin('shelf', function ($join) {
                                $join->on('shelf.id', '=', 'products.shelf_id');
                            })
                            ->get()
                            ->toArray();
        $product_ids = array_map(function ($item) {
            return $item['id'];
        }, $product_records);

        $product_stocks = DB::table('stock')
                            ->select(['stock.id', DB::raw('SUM(stock.qty) AS total_stock')])
                            ->whereIn('id', $product_ids)
                            ->groupBy('stock.product_id', 'stock.id')
                            ->get();
        $product_stocks_ids = array();
        foreach ($product_stocks as $product)
        {
            $product_stocks_ids[$product_stocks->id] = $product->total_stock;
        }

        foreach ($product_records as $index => $product_record) 
        {
            $product_records[$index]->stock = $product_stocks_ids[$product_record->id];   
        }
        $data['products'] = $product_records;
        $data['total_row'] = count($product_records);
        return view('admin.product.index', $data);
    }

    public function category(Request $request)
    {
        $data['category'] = DB::table('category')
                                ->select(['category.id', 'category.name', DB::raw('COUNT(products.id) AS total_product')])
                                ->leftJoin('products', function($join) {
                                    $join->on('products.category_id', '=', 'category.id');
                                })
                                ->groupBy('category.id', 'category.name')
                                ->get();
        $data['total_row'] = count($data['category']);
        return view('admin.category.index', $data);
    }

    public function shelf(Request $request)
    {
        $data['shelf'] = DB::table('shelf')
                                ->select(['shelf.id', 'shelf.name', DB::raw('COUNT(products.id) AS total_product')])
                                ->leftJoin('products', function($join) {
                                    $join->on('products.shelf_id', '=', 'shelf.id');
                                })
                                ->groupBy('shelf.id', 'shelf.name')
                                ->get();
        $data['total_row'] = count($data['shelf']);
        return view('admin.shelf.index', $data);
    }

    public function createFormShelf()
    {
        $data['page_title'] = 'Buat Rak Baru';
        $data['target_route'] = 'shelf.create';
        return view('admin.shelf.form', $data);
    }

    public function createShelf(Request $request)
    {
        $user_input_field_rules = array (
            'name' => 'required|min:5'
        );
        $user_input = $request->only('name');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		DB::table('shelf')->insert($user_input);
		return redirect()
					->route('shelf.index')
					->with(['success' => 'Rak baru berhasil ditambahkan']);
    } 


    public function editFormShelf(Request $request, $shelfId)
    {
        $current_record = DB::table('shelf')->where('id', $shelfId)->first();
        if (!$current_record) {
            return redirect()
                ->route('shelf.index')
                ->with(array (
                    'error' => 'Rak tidak ditemukan'
                ));
        }
        $data['item'] = $current_record;
        $data['page_title'] = 'Mengubah Rak';
        $data['target_route'] = 'shelf.edit';
        return view('admin.shelf.form', $data);
    }

    public function editShelf(Request $request)
    {
        $shelfId = $request->input('id');
        $current_record = DB::table('shelf')->where('id', $shelfId)->first();
        if (!$current_record) {
            return redirect()
                ->route('shelf.index')
                ->with(array (
                    'error' => 'Rak tidak ditemukan'
                ));
        }

        $user_input_field_rules = array (
            'name' => 'required|min:5'
        );
        $user_input = $request->only('name');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		DB::table('shelf')->where(array('id' => $shelfId))->update($user_input);
		return redirect()
					->route('shelf.index')
					->with(['success' => 'Rak berhasil dirubah']); 
    }

    public function deleteShelf(Request $request, $shelfId) {
        $current_record = DB::table('shelf')->where('id', $shelfId)->first();
        if (!$current_record) {
            return redirect()
                ->route('shelf.index')
                ->with(array (
                    'error' => 'Rak tidak ditemukan'
                ));
        }

        $product_shelf = DB::table('products')->where('shelf_id', $shelfId)->get();
        if (count($product_shelf) > 0) {
            return redirect()
                ->route('shelf.index')
                ->with(array (
                    'error' => 'Rak tidak bisa dihapus, karena masih digunakan dibeberapa produk'
                )); 
        }

        DB::table('shelf')->where(array ('id' => $shelfId))->delete();
        return redirect()
				->route('shelf.index')
				->with(['success' => 'Rak baru berhasil hapus']);  
    }

    public function createFormCategory()
    {
        $data['page_title'] = 'Buat Kategori';
        $data['target_route'] = 'category.create';
        return view('admin.category.form', $data);
    }

    public function createCategory(Request $request)
    {
        $user_input_field_rules = array (
            'name' => 'required|min:5'
        );
        $user_input = $request->only('name');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		DB::table('category')->insert($user_input);
		return redirect()
					->route('category.index')
					->with(['success' => 'Kategori baru berhasil ditambahkan']);
    } 


    public function editFormCategory(Request $request, $categoryId)
    {
        $current_record = DB::table('category')->where('id', $categoryId)->first();
        if (!$current_record) {
            return redirect()
                ->route('category.index')
                ->with(array (
                    'error' => 'Kategri tidak ditemukan'
                ));
        }
        $data['item'] = $current_record;
        $data['page_title'] = 'Mengubah kategori';
        $data['target_route'] = 'category.edit';
        return view('admin.category.form', $data);
    }

    public function editCategory(Request $request)
    {
        $categoryId = $request->input('id');
        $current_record = DB::table('category')->where('id', $categoryId)->first();
        if (!$current_record) {
            return redirect()
                ->route('category.index')
                ->with(array (
                    'error' => 'Kategri tidak ditemukan'
                ));
        }

        $user_input_field_rules = array (
            'name' => 'required|min:5'
        );
        $user_input = $request->only('name');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		DB::table('category')->where(array('id' => $categoryId))->update($user_input);
		return redirect()
					->route('category.index')
					->with(['success' => 'Kategori baru berhasil dirubah']); 
    }

    public function deleteCategory(Request $request, $categoryId) {
        $current_record = DB::table('category')->where('id', $categoryId)->first();
        if (!$current_record) {
            return redirect()
                ->route('category.index')
                ->with(array (
                    'error' => 'Kategori tidak ditemukan'
                ));
        }

        $product_category = DB::table('products')->where('category_id', $categoryId)->get();
        if (count($product_category) > 0) {
            return redirect()
                ->route('category.index')
                ->with(array (
                    'error' => 'Kategori tidak bisa dihapus, karena masih digunakan dibeberapa produk'
                )); 
        }

        DB::table('category')->where(array ('id' => $categoryId))->delete();
        return redirect()
				->route('category.index')
				->with(['success' => 'Kategori baru berhasil hapus']);  
    }
}
