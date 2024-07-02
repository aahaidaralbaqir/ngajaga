<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleBasedAccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $permission_id)
    {
        $user_record = $request->user();
        $role_record = DB::table('roles')
                            ->where('id', $user_record->role_id)
                            ->first();
        if (!$role_record) {
            return route('login');
        }
        $permission_ids = explode(',', $role_record->permission);
        $has_access = in_array($permission_id, $permission_ids);
        if (!$has_access) {
            return redirect()->route('unauthorized'); 
        } else {
            return $next($request);
        }
    }
}
