<?php

use Carbon\Carbon;

use App\Models\City;
use App\Models\Country;
use App\Models\Experience;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Generate Code 
 */
if (!function_exists('generateRandomCode')) {
	function generateRandomCode($string)
	{
		return $string . '-' . substr(md5(microtime()), rand(0, 26), 8);
	}
}
if (!function_exists('numberOfSpotsBooking')) {
	function numberOfSpotsBooking($experience_id, $passenger_id)
	{
		return DB::table('orders')->where('experience_id', $experience_id)
			->where('passenger_id', $passenger_id)
			->pluck('number_of_attendees')
			->first();
	}
}

if (!function_exists('uploadToPublic')) {
	function uploadToPublic($folder, $image)
	{
		return 'uploads/' . Storage::disk('public_new')->put($folder, $image);
	}
}

if (!function_exists('orderStatus')) {
	function orderStatus($status)
	{

		switch ($status) {
			case 0:
				return __("WITTING LOKLE");
				break;
			case 1:
				return __("APPROVE LOKLE");
				break;
			case 2:
				return __("WITTING PAYMENT");
				break;
			case 3;
				return __("APPROVE PAYMENT");
				break;
			case 4;
				return __("WITTING START");
				break;
			case 5;
				return __("START");
				break;
			case 6;
				return __("FINISH");
				break;
		}
	}
}
if (!function_exists('PaymentStatusForFriends')) {
	function PaymentStatusForFriends($status)
	{

		switch ($status) {
			case 0:
				return __("WAITING FOR PAY");
				break;
			case 1:
				return __("PAYED");
				break;
		}
	}
}

if (!function_exists('cacheRemember')) {
	function cacheRemember()
	{
		return 60 * 60 * 24;
	}
}
if (!function_exists('isFavorite')) {
	function isFavorite($experience_id, $passenger_id)
	{
		$experiences = DB::table('favorites')
			->where('passenger_id', $passenger_id)
			->pluck('experience_id')->toArray();

		if (!in_array($experience_id, $experiences)) {
			return false;
		}
		return true;
	}
}

if (!function_exists('isActive')) {
	function isActive($type, $end_date = "")
	{
		if ($type == 1 || $end_date >= now()) {
			return '<div class="badge badge-light-success fw-bolder">' . __("Active") . '</div>';
		} else {
			return '<div class="badge badge-light-danger fw-bolder">' . __("Not Active") . '</div>';
		}
	}
}
if (!function_exists('calculateAge')) {
	function calculateAge($birthday)
	{
		$age =  date_diff(date_create($birthday), date_create(date("d-m-Y")));
		return $age->format("%y");
	}
}
if (!function_exists('mostPopularExperienceForCaptain')) {
	function mostPopularExperienceForCaptain($captain_id)
	{
		$extension = Experience::where('captain_id', $captain_id)
			->orderBy('rate', 'DESC')->first();
		if (!$extension) return 'no have';
		return $extension->title;
	}
}
if (!function_exists('fullName')) {
	function fullName($first_name, $last_name)
	{
		return $first_name . ' ' . $last_name;
	}
}


if (!function_exists('gender')) {
	function gender($type)
	{
		if ($type == 1) {
			return 'male';
		} elseif ($type == 2) {
			return 'female';
		} elseif ($type == 3) {
			return 'other';
		}
	}
}

if (!function_exists('durationType')) {
	function durationType($type)
	{
		if ($type == 1) {
			return 'day';
		} elseif ($type == 2) {
			return 'minutes';
		}
	}
}
if (!function_exists('availableCapacity')) {
	function availableCapacity($experience_id)
	{
		return DB::table('orders')
			->where('experience_id', $experience_id)
			->sum('number_of_attendees');
	}
}
/**
 * Upload
 */
if (!function_exists('upload')) {
	function upload($file, $path)
	{
		$baseDir = 'uploads/' . $path;

		$name = sha1(time() . $file->getClientOriginalName());
		$extension = $file->getClientOriginalExtension();
		$fileName = "{$name}.{$extension}";

		$file->move(public_path() . '/' . $baseDir, $fileName);

		return "{$baseDir}/{$fileName}";
	}
}

if (!function_exists('cities')) {
	function cities()
	{
		$cities = City::get();
		return $cities;
	}
}
if (!function_exists('countries')) {
	function countries()
	{
		$countries = Country::get();
		return $countries;
	}
}
if (!function_exists('getCountry')) {
	function getCountry($city_id)
	{
		$city = City::whereId($city_id)->select('country_id')->first();
		return $city->country_id;
	}
}


if (!function_exists('userSuspend')) {
	function userSuspend($type)
	{
		if ($type == true) {
			return '<a href="#"><div class="badge badge-light-danger fw-bolder">' .  __("Freeze")  . '</div></a>';
		} elseif ($type == false) {
			return '<a href="#"><div class="badge badge-light-success fw-bolder">' . __("Active") . '</div></a>';
		}
	}
}

if (!function_exists('userStatus')) {
	function userStatus($type)
	{
		if ($type == true) {
			return '<a href="#"><div class="badge badge-light-success fw-bolder">' . __("verify") . '</div></a>';
		} elseif ($type == false) {
			return '<a href="#"><div class="badge badge-light-danger fw-bolder">' . __("Un Verify") . '</div></a>';
		}
	}
}

if (!function_exists('status')) {
	function status($status)
	{
		if ($status == Experience::ACCEPT) {
			return __("ACCEPT");
		} elseif ($status == Experience::PENDING) {
			return __("PENDING");
		} elseif ($status == Experience::REJECT) {
			return __("REJECT");
		} elseif ($status == Experience::EXPIRED) {
			return __("EXPIRED");
		}
	}
}
