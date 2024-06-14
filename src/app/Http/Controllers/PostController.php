<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

	public function index(Request $request)
	{
		$search_query = $request->input('query');
		$user_profile = $this->getUser();
        $data = array_merge(array(), $user_profile);
		if ($request->has('query'))
		{
			$posts =  Post::where('title', 'LIKE', '%' . $search_query . '%')
						 ->paginate(Constant::MAX_PAGINATION);
			$data['posts'] = $posts;
        	return view('admin.post.index', $data);
		}
		$posts =  Post::paginate(Constant::MAX_PAGINATION);
		$data['posts'] = $posts;
		return view('admin.post.index', $data);
	}

    public function showCreateForm(Request $request) 
    {
        $user_profile = $this->getUser();
        $data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
        $data['categories'] = CommonUtil::getCategories(); 
        return view('admin.post.form', $data);
    }

	public function showUpdateForm(Request $request, $postId)
	{
		if (empty($postId))
			return redirect()
				->route('post.index')
				->with(['error' => 'Gagal mengupdate banner, id diperlukan']);
	
		$user_profile = $this->getUser();
        $data = array_merge(array(), $user_profile);
			
		$record = Post::find($postId);
		$data['item'] = $record;
        $data['categories'] = CommonUtil::getCategories(); 
        $data['status'] = CommonUtil::getStatus(); 
        return view('admin.post.form', $data);	
	}

    public function updatePost(Request $request)
    {
		$post_id = $request->id;
		if (empty($post_id))
			return back()
					->with(['error' => 'Gagal mengupdate tulisan, id diperlukan']);
		
		$current_record = Post::find($post_id);
		if (empty($current_record))
			return back()
					->with(['error' => 'Gagal mengupdate tulisan, id diperlukan']);
		
		$current_user = Auth::user();
        $user_input_field_rules = [
			'title' => 'required|min:10|max:200',
			'category'	=> 'required|in:'.implode(',', array_keys(CommonUtil::getCategories())),
			'status'	=> 'required|in:'.implode(',', array_keys(CommonUtil::getStatus())),
			'content' => 'required'
		];
		
		$user_input =  $request->only('title', 'category', 'content', 'status');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if ($request->hasFile('image'))
		{
			$file_location = 'public/posts/' . CommonUtil::getFileName($current_record->banner);
			Storage::delete($file_location);
			$filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
			$path = $request->file('image')->storeAs('public/posts', $filename);
			if (empty($path))
			{
				return back()->withErrors(['banner' => 'Gagal mengupload banner'])
							->withInput();
			}
			$user_input['banner'] = $filename;
		}
		

		$user_input['user_id'] = $current_user->id;
		$user_input['content'] = htmlspecialchars($request->input('content'));
		Post::where('id', $post_id)->update($user_input);
		return redirect()
					->route('post.index')
					->with(['success' => 'Berhasil mengubah tulisan']);	
    }   
    
    public function createPost(Request $request)
	{
		$current_user = Auth::user();
        $user_input_field_rules = [
			'title' => 'required|min:10|max:200',
			'category'	=> 'required|in:'.implode(',', array_keys(CommonUtil::getCategories())),
			'content' => 'required'
		];

		$user_input =  $request->only('title', 'category', 'content');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		$filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
		$path = $request->file('image')->storeAs('public/posts', $filename);
		if (empty($path))
		{
			return back()->withErrors(['banner' => 'Gagal mengupload banner'])
						->withInput();
		}

		$user_input['banner'] = $filename;
		$user_input['user_id'] = $current_user->id;
		$user_input['content'] = htmlspecialchars($request->input('content'));
		Post::create($user_input);
		return redirect()
					->route('post.index')
					->with(['success' => 'Berhasil menambahkan banner baru']);
	}
}
