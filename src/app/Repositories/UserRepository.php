<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class UserRepository {
   public static function getUsers()
   {
        $user_records = DB::table('users')
            ->get();
        return $user_records;
   }
}