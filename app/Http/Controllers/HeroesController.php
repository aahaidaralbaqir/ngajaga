<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heroes;
use Illuminate\Support\Facades\Validator;
use App\Constant\Constant;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class HeroesController extends Controller
{
    public function index()
    {
        $user_profile = $this->initProfile();
        $data = array_merge(array(), $user_profile);
        $heroes =  Heroes::orderBy('order', 'ASC')->get();
        $results = $heroes->toArray();
        $data['heroes'] = $results;
        return view('admin.heroes.index', $data);
    }

    public function showUpdateForm(Request $request, $id)
    {
        $user_profile = $this->initProfile();
        $data = array_merge(array(), $user_profile);
        $item =  Heroes::find($id);
        $data['item'] = $item;
        return view('admin.heroes.form', $data);
    }

    public function createHeroes(Request $request)
    {
        $user_input_field_rule = [
            'link'          => 'required|url',
            'title'         => 'required|max:50',
            'subtitle'      => 'required|min:10|max:200',
            'description'   => 'required|max:200'
        ];

        $user_input = $request->only('title', 'subtitle', 'description', 'link');

        $validator = Validator::make($user_input, $user_input_field_rule);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
        
        if (!$request->hasFile('image'))
        {
            return back()->withErrors(['banner' => 'Banner wajib di isi'])
                        ->withInput();
        }
            
        
        $filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
        $path = $request->file('image')->storeAs('public/banners', $filename);
        if (empty($path))
        {
            return back()->withErrors(['banner' => 'Gagal mengupload gambar'])
                        ->withInput();
        }
             
        $heroes = Heroes::all();
        $user_input['image'] = $filename;
        $length_heroes = count($heroes);
        $user_input['order'] = $length_heroes + 1;
        Heroes::create($user_input);
        return redirect()
					->route('heroes.index')
					->with(['success' => 'Berhasil menambahkan banner baru']);
    }

	public function updateHeroes(Request $request)
	{
		$user_input_field_rule = [
            'link'          => 'required|url',
            'title'         => 'required|max:50',
            'subtitle'      => 'required|min:10|max:200',
            'description'   => 'required|max:200'
        ];

		$heroes_id = $request->id;
		if (empty($heroes_id))
		{
			return back()
					->with(['error' => 'Gagal mengupdate, record tidak ditemukan']);	
		}

		$record = Heroes::find($heroes_id);
		if (empty($record)) 
		{
			return back()
					->with(['error' => 'Gagal mengupdate, record tidak ditemukan']);	
		}

        $user_input = $request->only('title', 'subtitle', 'description', 'link');
		
        $validator = Validator::make($user_input, $user_input_field_rule);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
        
        
		if ($request->hasFile('image'))
        {
			$file_location = 'public/banners/' . $record->image;
			Storage::delete($file_location);
			$filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
			$path = $request->file('image')->storeAs('public/banners', $filename);
			if (empty($path))
			{
				return back()->withErrors(['banner' => 'Gagal mengupload gambar'])
							->withInput();
			}
			$user_input['image'] = $filename;
        }
        Heroes::where('id', $heroes_id)
				->update($user_input);
        return redirect()
					->route('heroes.index')
					->with(['success' => 'Berhasil mengupdate banner']);	
	}

    public function showCreateForm(Request $request)
    {
        $user_profile = $this->initProfile();
        $data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
        return view('admin.heroes.form', $data);
    }

	public function showEditForm(Request $request, $heroesId)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		
		$record = Heroes::find($heroesId);
		if (empty($record))
			return redirect()
				->route('heroes.index')
				->with(['error' => 'Gagal mengupdate banner, record tidak ditemukan']);
		
		$data['item'] = $record;
		return view('admin.heroes.form', $data);
	}

	public function updateOrder(Request $request, string $heroesId)
	{
		if (!$request->has('order_type'))
			return back()
				->with(['error' => 'Gagal mengupdate order, type order tidak dicantumkan']);	

		$order_type = $request->input('order_type');
		if (!in_array($order_type, [Constant::ORDER_UP, Constant::ORDER_DOWN]))
			return back()
				->with(['error' => 'Gagal mengupdate order, type order tidak tersedia']);	

		if (empty($heroesId))
		{
			return back()
				->with(['error' => 'Gagal mengupdate order, id heroes di perlukan']);	
		}

		$record = Heroes::find($heroesId);
		if (empty($record))
			return back()
				->with(['error' => 'Gagal mengupdate order, record tidak ditemukan']);	

		$current_order = (int) $record->order;
		$records = array(Constant::ORDER_UP => Heroes::where('order', '<', $current_order)->orderBy('order', 'DESC')->first(),
						 Constant::ORDER_DOWN => Heroes::where('order', '>', $current_order)->orderBy('order', 'ASC')->first());
		$updated_record = $records[$order_type];
		
		if (!empty($updated_record))
		{
			$tobe_updated_record = array(Constant::ORDER_UP => $updated_record->order + 1,
						 			 	 Constant::ORDER_DOWN => $updated_record->order - 1);	
			Heroes::where('id', $updated_record->id)
				->update(['order' => $tobe_updated_record[$order_type]]);
		}
			
		$current_order = (int) $record->order - 1;
		if ($order_type == Constant::ORDER_DOWN)
			$current_order = (int) $record->order + 1;
		
		if (!empty($updated_record)) 
			Heroes::where('id', $record->id)
				->update(['order' => $current_order]);

		return redirect()
					->route('heroes.index')
					->with(['success' => 'Berhasil mengupdate urutan banner']);	
	}
}
