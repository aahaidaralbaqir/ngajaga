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
			Constant::UNIT_LUSIN => 'Lusin',
			Constant::UNIT_LTR => 'Liter',
			Constant::UNIT_PACK => 'paK'
		];
	}

	public static function getUnitNameById($unit_id) {
		$units = self::getUnits();
		return $units[$unit_id];
	}

	public static function getUnitByIds($unit_ids) {
		$units = self::getUnits();
		$data = [];
		foreach ($unit_ids as $unit_id) {
			$data[] = [
				'id' => $unit_id,
				'name' => $units[$unit_id]
			]; 
		}
		return $data;
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
			Constant::PURCHASE_ORDER_VOID => 'Dibatalkan',
			Constant::PURCHASE_ORDER_WAITING => 'Menunggu',
			Constant::PURCHASE_ORDER_COMPLETED => 'Selesai'
		];
	}

	public static function getBadgeByStatus($status)
	{
		$badge = [
			Constant::PURCHASE_ORDER_VOID => 'badge-danger',
			Constant::PURCHASE_ORDER_WAITING => 'badge-warning',
			Constant::PURCHASE_ORDER_COMPLETED => 'badge-success',
		];

		return $badge[$status];
	}

	public static function generateOrderId($latest_id) {
		// Generate a unique ID based on current time in microseconds
		$unique_id = uniqid();

		// Add characters (e.g., 'ORD') to the order ID
		$characters = 'TRX';

		// Format the current date (e.g., YYMMDD)
		$current_date = date('ymd');

		// Calculate available space for unique_id after adding characters and date
		$max_unique_id_length = 9 - strlen($characters) - strlen($current_date);

		// Truncate unique_id to fit within available space
		$truncated_unique_id = substr($unique_id, 0, $max_unique_id_length);

		// Combine all parts to form the final order ID
		$order_id = $characters . $current_date . $truncated_unique_id . $latest_id;
		return $order_id;
	}

	public static function shortentText($text, $num_characters = 7) {
		// Check if text length exceeds specified number of characters
		if (strlen($text) <= $num_characters) {
			return $text; // Return the text as is if it's already shorter or equal to the specified length
		} else {
			// Trim the text to the specified number of characters
			$shortened_text = substr($text, 0, $num_characters);
	
			// Trim any incomplete word at the end
			$shortened_text = substr($shortened_text, 0, strrpos($shortened_text, ' '));
	
			// Append "...."
			$shortened_text .= '....';
	
			return $shortened_text;
		}
	}
	
}