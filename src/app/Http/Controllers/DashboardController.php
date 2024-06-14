<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		$user_profile = parent::getUser();
		$data['user'] = $user_profile;
		return view('admin.index', $data);
	}
}
