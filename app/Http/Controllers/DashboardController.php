<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		return view('admin.index', $data);
	}
}
