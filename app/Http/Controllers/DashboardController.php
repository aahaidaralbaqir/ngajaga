<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		$user = Auth::user();
		$data = ['name' => $user->name, 
				'role_name' => ucfirst(CommonUtil::getRoleNameById($user->role))];
		return view('admin.index', $data);
	}
}
