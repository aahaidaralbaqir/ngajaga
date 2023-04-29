<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\Common as CommonUtil;

class PostController extends Controller
{
    public function showCreateForm(Request $request) 
    {
        $user_profile = $this->initProfile();
        $data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
        $data['categories'] = CommonUtil::getCategories(); 
        return view('admin.post.form', $data);
    }

    public function updatePost(Request $request)
    {

    }   
    
    public function createPost(Request $request)
	{
		
	} 
}
