<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Constant\Permission;
use App\Repositories\ProductRepository;
use App\Util\Common;
use App\Util\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product_records = ProductRepository::getProducts($request->all());
        $product_ids = [];
        foreach ($product_records as $product_record) {
            $product_ids[] = $product_record->id;
        }
        $product_stocks = ProductRepository::getProductStockByIdsProduct($product_ids);
        $product_stocks_ids = array();
        foreach ($product_stocks as $product)
        {
            $product_stocks_ids[$product->product_id] = $product->total_stock;
        }
        $price_mapping_records = ProductRepository::getProductLowestPriceByIds($product_ids);
        $price_mapping_ids = array();
        foreach ($price_mapping_records as $price_mapping)
            $price_mapping_ids[$price_mapping->product_id] = $price_mapping->lowest_price;

        foreach ($product_records as $index => $product_record) 
        {
            $stock = 0;
            if (array_key_exists($product_record->id, $product_stocks_ids))
                $stock = $product_stocks_ids[$product_record->id];  
            $lowest_price = 0;
            if (array_key_exists($product_record->id, $price_mapping_ids))
                $lowest_price = $price_mapping_ids[$product_record->id];  
            $product_records[$index]->image = Common::getStorage(Constant::STORAGE_PRODUCT, $product_record->image);
            $product_records[$index]->stock = $stock;
            $product_records[$index]->lowest_price = $lowest_price;
        }
        return view('admin.product.index')
            ->with('user', parent::getUser())
            ->with('has_filter', $request->query->count() > 0)
            ->with('products', $product_records);
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
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
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
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
        return view('admin.shelf.index', $data);
    }

    public function createFormShelf()
    {
        $data['page_title'] = 'Buat Rak Baru';
        $data['target_route'] = 'shelf.create';
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
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
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
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
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
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
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
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

    public function createProductForm(Request $request) {
        $data['categories'] = DB::table('category')->get();
        $data['shelfs'] = DB::table('shelf')->get();
        $data['target_route'] = 'product.create';
        $data['page_title'] = 'Product apa yang akan kamu buat ?';
        $data['units'] = Common::getUnits();
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
        return view('admin.product.form', $data); 
    }

    public function createProduct(Request $request) {
        $user_input_field_rules = array (
            'name'          => 'required',
            'category_id'   => 'required',
            'shelf_id'      => 'required',
        );
        $user_input = $request->only('name', 'category_id', 'shelf_id', 'description');
        $validator = Validator::make($user_input, $user_input_field_rules);


		if ($validator->fails())
        {
            return back()
				->withErrors($validator)
				->withInput();
        }

        if (!$request->hasFile('image')) {
            return back()
                ->withErrors(['image' => 'Gambar produk harus diisi'])
				->withInput();
        }

        $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
		$path = $request->file('image')->storeAs('public/products', $filename);
		if (empty($path))
		{
			return back()->withErrors(['banner' => 'Gambar gagal di upload, silahkan ulangi kembali'])
						->withInput();
		}
        $user_input['image'] = $filename;

        if (empty($user_input['sku'])) {
            $user_input['sku'] = Common::generateUniqueSku();
        }

        $user_input['updated_by'] = Auth::user()->id;
        $product_id = DB::table('products')->insertGetId($user_input);
        return redirect()
			->route('product.price.form', ['productId' => $product_id])
			->with(['success' => 'Produk berhasil ditambahkan']);
    }

    public function editProductForm(Request $request, $productId) {
        $current_record = DB::table('products')->where('id', $productId)->first();
        if (!$current_record) {
            return redirect()
                ->route('product.index')
                ->with(array (
                    'error' => 'Kategri tidak ditemukan'
                ));
        }
        $current_record->image = Common::getStorage(Constant::STORAGE_PRODUCT, $current_record->image);
        $data['units'] = Common::getUnits();
        $data['categories'] = DB::table('category')->get();
        $data['shelfs'] = DB::table('shelf')->get();
        $data['item'] = $current_record;
        $data['page_title'] = 'Mengubah Produk';
        $data['target_route'] = 'product.edit';
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
        return view('admin.product.form', $data); 
    }
    
    public function editProduct(Request $request) {
        $user = parent::getUser();
        $current_record = DB::table('products')
                            ->where('id', $request->id)
                            ->first();
        if (!$current_record) {
            return redirect()
                    ->route('product.index')
                    ->with(array (
                        'error' => 'Produk tidak ditemukan'
                    ));
        }

        $user_input_field_rules = array (
            'name' => 'required',
            'category_id' => 'required',
            'shelf_id' => 'required',
        );
        $user_input = $request->only('name', 'category_id', 'shelf_id', 'description');
        $validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
            return back()
					->withErrors($validator)
					->withInput();
        }

        if ($request->hasFile('image')) {
            $file_location = 'public/products/' . $current_record->image;
			Storage::delete($file_location);
			$filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
			$path = $request->file('image')->storeAs('public/products', $filename);
			if (empty($path))
			{
				return back()->withErrors(['image' => 'Gambar gagal diperbaharui'])
							->withInput();
			}
			$user_input['image'] = $filename;
        }

        DB::table('products')
            ->where('id', $current_record->id)
            ->update($user_input);

        if (in_array(Permission::CONFIGURE_PRICE, $user['permission'])) { 
            return redirect()
                ->route('product.price.form', ['productId' => $current_record->id]); 
        }
        return redirect()
            ->route('product.index')
            ->with(array (
                'success' => 'Produk berhasil dirubah'
            )); ;
    }

    public function editPriceForm(Request $request, $productId) {
        $current_record = DB::table('products')->where('id', $productId)->first();
        if (!$current_record) {
            return redirect()
                ->route('product.index')
                ->with(array (
                    'error' => 'Kategri tidak ditemukan'
                ));
        }
        $current_record->image = Common::getStorage(Constant::STORAGE_PRODUCT, $current_record->image);
        $data['price_mapping'] = DB::table('price_mapping')->where('product_id', $productId)->get();
        $data['units'] = Common::getUnits();
        $data['item'] = $current_record;
        $data['page_title'] = 'Mengubah Konfigurasi Harga';
        $data['target_route'] = 'product.price';
        $user_profile = parent::getUser();
		$data['user'] = $user_profile;
        return view('admin.product.price', $data);  
    }

    public function editPrice(Request $request) {
        $product_id = $request->input('id');
        $current_record = DB::table('products')
                            ->where('id', $product_id)
                            ->first();
        if (!$current_record) {
            return redirect()
                ->route('product.index')
                ->with(array (
                    'error' => 'Produk tidak ditemukan'
                )); 
        }
        $user_input_field_rules = [
            '*.qty'         => 'required',
            '*.price'       => 'required',
            '*.conversion'  => 'required',
            '*.unit'        => 'required|in:' . implode(',', array_keys(Common::getUnits())),
        ];


        $user_input = [];
        $user_input_length = count($request->input('unit'));
        for ($sequence = 0; $sequence < $user_input_length; $sequence++) {
            $user_input[] = [
                'product_id' => $product_id,
                'unit' => $request->input('unit')[$sequence],
                'conversion' => $request->input('conversion')[$sequence],
                'price' => $request->input('price')[$sequence],
                'qty' => $request->input('qty')[$sequence]
            ];
        }

        $unit = [];
        foreach ($user_input as $index => $input) 
        {
            if (array_key_exists($input['unit'], $unit)) {
                return Response::backWithError('Satuan tidak boleh sama disetiap konfigurasinya'); 
            }
            $unit[$input['unit']] = true;
            $fields = array_keys($input);
            foreach ($fields as $field)
            {
                if (empty($input[$field]))
                {
                    $user_input[$index][$field] = 0;           
                }
            }
        }

        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
				->withInput();
        }
        if (count($user_input) <= 0) {
            return Response::backWithError('Konfigurasi harga harus di isi minimal satu');
        }

        DB::table('price_mapping')->where('product_id', $product_id)->delete();
        if (count($user_input) > 0) {
            DB::table('price_mapping')
                ->insert($user_input);
        }
       
        return redirect()
                ->route('product.index')
                ->with(array (
                    'success' => 'Produk berhasil dirubah'
                )); 
    }

    public static function getProducts() {
        return DB::table('products')
            ->get();
    }

    public static function getUnitByProductsIds($product_ids) {
        return DB::table('price_mapping')
            ->whereIn('product_id', $product_ids)
            ->get();
    }

    public function getUnits() {
        $product_units = ProductRepository::getProductUnit();
        $results = [
            'status' => true,
            'units' => $product_units];
        return response()
            ->json($results, 200);
    }

    public function getProductMappingByProductId(Request $request)
    {
        $product_id = $request->get('product_id');
        $price_mapping_records = ProductRepository::getPriceMappingByProductId($product_id);
        $units = Common::getUnits();
        foreach ($price_mapping_records as $index => $price_mapping)
        {
            $price_mapping->unit_name = $units[$price_mapping->unit];
            $price_mapping_records[$index] = $price_mapping;
        }
        $results = [
            'status' => true,
            'price_mapping' => $price_mapping_records
        ];
        return response()
            ->json($results, 200);
    }

    public function getProductLowestPriceById($product_id) 
    {
        return DB::table('price_mapping')
            ->where('product_id', $product_id)
            ->orderBy('id', 'asc')
            ->first();
    }
      
}
