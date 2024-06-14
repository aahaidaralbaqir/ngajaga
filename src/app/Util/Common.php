<?php 

namespace App\Util;
use App\Constant\Constant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Common {
	

	public static function getStatusExcept($statuses = array())
	{
		$status = [];
		foreach(self::getStatus() as $key => $value)
			if (!in_array($key, $statuses)) $status[$key] = $value; 
		return $status;
	}

	public static function getStatus()
	{
		return [Constant::STATUS_ACTIVE => Constant::STATUS_ACTIVE_NAME,
				Constant::STATUS_INACTIVE => Constant::STATUS_INACTIVE_NAME];
	}

	public static function getStatusById($id)
	{
		$available_status = self::getStatus();
		if (!array_key_exists($id, $available_status))
			return 'Unknow status';
		return $available_status[$id];	
	}

	public static function getStorage($storage_name, $filename) 
	{
		return '/storage/' .$storage_name. '/' . $filename;
	}

	public static function getFileName($fullpath) 
	{
		$path = explode('/', $fullpath);
		if (empty($path))
			return $fullpath;
		return $path[count($path) - 1];
	}

	public static function getDayOptions()
    {
        return [
            'monday'    => [
				'id'	=> 'monday',
                'name'  => 'Senin',
                'bit'   => pow(2, 0)],
			'tuesday'    => [
				'id'	=> 'tuesday',
				'name'  => 'Selasa',
				'bit'   => pow(2, 1)],
			'wednesday'   => [
				'id'	=> 'wednesday',
				'name'  => 'Rabu',
				'bit'   => pow(2, 2)],
			'thursday'   => [
				'id'	=> 'thursday',
				'name'  => 'Kamis',
				'bit'   => pow(2, 3)],
			'friday'   => [
				'id'	=> 'friday',
				'name'  => 'Jumat',
				'bit'   => pow(2, 4)],
			'saturday'   => [
				'id'	=> 'saturday',
				'name'  => 'Sabtu',
				'bit'   => pow(2, 5)],
			'sunday'   => [
				'id'	=> 'sunday',
				'name'  => 'Minggu',
				'bit'   => pow(2, 6)]];
    }

	public static function getBitOptionsFromValue($bit_options, $value)
    {
        $selected_options = array();

        foreach ($bit_options as $key=>$option)
        {
            if (($value & $option['bit']) === $option['bit'])
                $selected_options[$key] = $option;
        }

        return $selected_options;
    }

	public static function getBitOptionValueFormIds($bit_options, $ids = [])
    {
        $value = 0;
        
        foreach ($ids as $id)
        {
            if (array_key_exists($id, $bit_options))
                $value = $value | $bit_options[$id]['bit'];
        }
        
        return $value;
    }

	public static function getDayOptionsFromValue($value)
    {
        return self::getBitOptionsFromValue(self::getDayOptions(), $value);
    }
    
    public static function getDayValueFromCheckOptionIds($ids = [])
    {
        return self::getBitOptionValueFormIds(self::getDayOptions(), $ids);
    }

	public static function trimWord($text, $maxLength = 100, $suffix = '...') {
		if (strlen($text) <= $maxLength) {
			return $text;
		}
	
		$trimmedText = substr($text, 0, $maxLength);
		$lastSpaceIndex = strrpos($trimmedText, ' ');
	
		if ($lastSpaceIndex !== false) {
			$trimmedText = substr($trimmedText, 0, $lastSpaceIndex);
		}
	
		return $trimmedText . $suffix;
	}

	public static function formatAmount($unit_name, $amount) {
		if ($unit_name != Constant::UNIT_NAME_RUPIAH)
		{
			return $amount . ' ' . $unit_name;
		}
		$formattedAmount = number_format($amount, 0, ',', '.');
		return 'Rp ' . $formattedAmount;
	}

	public static function getDatesFromRange($start, $end, $format='Y-m-d') {
		return array_map(function($timestamp) use($format) {
			return date($format, $timestamp);
		},
		range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400));
	}

	public static function getHttpVerbOptions()
	{
		return [
			Constant::HTTP_VERB_DELETE,
			Constant::HTTP_VERB_PATCH,
			Constant::HTTP_VERB_PUT,
			Constant::HTTP_VERB_GET,
			Constant::HTTP_VERB_POST,
			Constant::HTTP_VERB_HEAD
		];
	}

	public static function getUnits()
	{
		return [
			Constant::UNIT_BKS => 'Bungkus',
			Constant::UNIT_PCS => 'Pcs',
			Constant::UNIT_KG => 'Kilogram',
			Constant::UNIT_LUSIN => 'Lusin'
		];
	}

	public static function generateUniqueSku($length = 8) {
		// Generate a random SKU
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $sku = '';
        for ($i = 0; $i < $length; $i++) {
            $sku .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Check if SKU is unique
        while (DB::table('products')->where('sku', $sku)->exists()) {
            $sku = '';
            for ($i = 0; $i < $length; $i++) {
                $sku .= $characters[rand(0, strlen($characters) - 1)];
            }
        }

        return $sku;
	}

	public static function formatTime($unix_timestamp, $layout = 'd F Y') {
		Carbon::setLocale('id');

		$date = Carbon::createFromTimestamp($unix_timestamp);

		$formated_date = $date->translatedFormat($layout);

		return $formated_date;
	}

	public static function getPurchaseOrderStatuses() {
		return [
			Constant::PURCHASE_ORDER_VOID => 'Void',
			Constant::PURCHASE_ORDER_DRAFT => 'Draft',
			Constant::PURCHASE_ORDER_WAITING => 'Waiting',
			Constant::PURCHASE_ORDER_COMPLETED => 'Completed'
		];
	}
}