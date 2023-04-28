<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Heroes;
use Illuminate\Support\Facades\Validator;
use App\Constant\Constant;
use App\Util\Common as CommonUtil;

class HeroesController extends Controller
{
    public function index()
    {
        $user_profile = $this->initProfile();
        $data = array_merge(array(), $user_profile);
        $heroes =  Heroes::all();
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

    public function showCreateForm(Request $request)
    {
        $user_profile = $this->initProfile();
        $data = array_merge(array(), $user_profile);
        return view('admin.heroes.form', $data);
    }
}
