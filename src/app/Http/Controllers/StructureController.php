<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Structure;
use Illuminate\Support\Facades\Validator;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Storage;

class StructureController extends Controller
{
    public function index(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['structures'] = Structure::all();
		return view('admin.structure.index', $data);
    }

    public function showCreateStructureForm(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $data['item'] = NULL;
        $data['structures'] = Structure::all();
		return view('admin.structure.form', $data); 
    }

    public function createStructure(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
			'title' => 'required',
		];
		$user_input = $request->only('name', 'title', 'id_parent');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if (!$request->hasFile('avatar'))
			return back()->withErrors(['avatar' => 'Avatar wajib di isi'])
							->withInput();

		$filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
		$path = $request->file('avatar')->storeAs('public/avatars', $filename);
		if (empty($path))
		{
			return back()->withErrors(['avatar' => 'Gagal mengupload avatar'])
						->withInput();
		}
		
		$user_input['avatar'] = $filename;
	
		Structure::create($user_input);
		return redirect()
					->route('structure.index')
					->with(['success' => 'Berhasil menambahkan struktur organisasi baru']);
    }

    public function showEditStructureForm(Request $request, $structureId)
    {
        $current_record = Structure::find($structureId);
        if (empty($current_record))
        {
           return back()
                    ->with(['error' => 'Entitas tidak ditemukan']);
        }
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $data['item'] = $current_record;
		$structures = Structure::all()->toArray();
		
        $data['structures'] = array_filter($structures, function ($item) use ($current_record) {
			return $item['id'] != $current_record->id;
		});
		return view('admin.structure.form', $data); 
    }

    public function updateStructure(Request $request)
    {
        $current_record = Structure::find($request->id);
		if (empty($current_record))
			return back()
					->with(['error' => 'Gagal mengupdate jenis kegiatan, entitas tidak ditemukan']);
		
		$user_input_field_rules = [
			'name' => 'required',
			'title' => 'required'
		];
		$user_input = $request->only('name', 'title', 'id_parent');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if ($request->hasFile('avatar'))
		{
			$filename = time() . '.' . $request->file('avatar')->getClientOriginalExtension();
			$path = $request->file('avatar')->storeAs('public/avatars', $filename);
			if (empty($path))
			{
				return back()->withErrors(['avatar' => 'Gagal mengupload avatar'])
							->withInput();
			}
			$file_location = 'public/avatars/' . CommonUtil::getFileName($current_record->avatar);
			Storage::delete($file_location);
			$user_input['avatar'] = $filename;
		}
	
		Structure::where('id', $current_record->id)
				->update($user_input);
		return redirect()
					->route('structure.index')
					->with(['success' => 'Berhasil mengupdate strukur organisasi']);
    }

	public function deleteStructure(Request $request, $structureId)
	{
		$current_record = Structure::find($structureId);
        if (empty($current_record))
        {
           return back()
                    ->with(['error' => 'Entitas tidak ditemukan']);
        }
		
		Structure::where('id', $structureId)->delete();
		return redirect()
					->route('structure.index')
					->with(['success' => 'Berhasil menghapus strukur organisasi']);	
	}
}
