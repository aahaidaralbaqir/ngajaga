<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class RoleRepository {
   public static function getRoles($user_param = [])
   {
        $role_records = DB::table('roles AS ro')
            ->addSelect('ro.id')
            ->addSelect('ro.name')
            ->addSelect('ro.permission')
            ->addSelect('ro.status')
            ->addSelect(DB::raw('COUNT(us.id) AS total_user'))
            ->leftJoin('users AS us', 'us.role_id', '=', 'ro.id')
            ->groupBy('ro.id', 'ro.name', 'ro.permission', 'ro.status')
            ->get();
        foreach ($role_records as $idx => $role_record)
        {
            $permission_ids = explode(',', $role_record->permission);
            $permission_records = PermissionRepository::getPermissionByIds($permission_ids);
            $role_records[$idx]->permissions = $permission_records;
        }

        return $role_records;
   }
   
   public static function createRole($user_input)
   {
        return DB::table('roles')
            ->insertGetId($user_input);
   }

   public static function getById($role_id)
   {
        return DB::table('roles')
            ->where('id', $role_id)
            ->first();
   }

   public static function updateRole($role_id, $user_input)
   {
        return DB::table('roles')
            ->where('id', $role_id)
            ->update($user_input);
   }
}