<?php
namespace App\Repositories;

use App\Constant\Constant;
use Illuminate\Support\Facades\DB;

class PermissionRepository {
    public static function getById($permission_id) 
    {
        return DB::table('permission')
            ->where('id', $permission_id)
            ->first();
    }

    public static function updatePermission($permission_id, $user_input)
    {
        return DB::table('permission')
            ->where('id', $permission_id)
            ->update($user_input);
    }

    public static function createPermission($user_input)
    {
        return DB::table('permission')
            ->insertGetId($user_input);
    }

    public static function getTotalPermission($query)
    {
    }

    public static function getPermissions()
    {
        $query = DB::table('permission AS pa')
            ->orderBy('pa.id_parent', 'ASC')
            ->get();
        return $query;
    }

    public static function getGroupedPermissions($permission_records) 
    {
        $parent_permission = [];
        $grouped_permissions = [];
        foreach ($permission_records as $index => $permission_record)
        {
            if ($permission_record->id_parent == Constant::PARENT_RECORD)
            {
                $parent_permission[] = $permission_record;
                continue;
            }

            if (array_key_exists($permission_record->id_parent, $grouped_permissions)) 
            {
                $grouped_permissions[$permission_record->id_parent][] = $permission_record;
                continue;
            }
            $grouped_permissions[$permission_record->id_parent] = [$permission_record];
        }


        foreach ($parent_permission as $index => $parent) 
        {
            $childs = [];
            if (array_key_exists($parent->id, $grouped_permissions))
            {
                $childs = $grouped_permissions[$parent->id];
            }
            $parent->childs = $childs;
            $parent_permission[$index] = $parent;
        }

        return $parent_permission;
    }

    public static function getParentPermissions()
    {
        $query = DB::table('permission')
            ->where('id_parent', Constant::PARENT_RECORD)
            ->get();
        return $query;
    }

    public static function getChildPermissions($parent_id)
    {
        $query = DB::table('permission')
            ->where('id_parent', $parent_id)
            ->get();
        return $query;
    }

    public static function getPermissionExcept($permission_id)
    {
        $query = DB::table('permission')
            ->where('id_parent', Constant::PARENT_RECORD)
            ->where('id', '!=', $permission_id)
            ->get();
        return $query;
    }

}