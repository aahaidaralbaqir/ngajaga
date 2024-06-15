<?php 

namespace App\Util;

class Response {
    public static function backWithError($error_msg = '') {
        return back()
            ->with(['error' => $error_msg]);
    }

    public static function backWithErrors($errors) {
        return back()
			->withErrors($errors)
			->withInput();
    }

    public static function redirectWithSuccess($route = '', $success_msg = '') 
    {
        return redirect()
            ->route($route)
            ->with(['success' => $success_msg]);
    }
}