<?php
/**
 * File: functions.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/10/9 20:34
 * Description:辅助函数
 */

/**
 * 生成友好时间形式
 *
 * @param $from
 *
 * @return false|string
 */
if (!function_exists('friendly_date')) {
	function friendly_date($from)
	{
		static $now = NULL;
		$now == NULL && $now = time();
		!is_numeric($from) && $from = strtotime($from);
		$seconds = $now - $from;
		$minutes = floor($seconds / 60);
		$hours   = floor($seconds / 3600);
		$day     = round((strtotime(date('Y-m-d', $now)) - strtotime(date('Y-m-d', $from))) / 86400);
		if ($seconds == 0) {
			return '刚刚';
		}
		if (($seconds >= 0) && ($seconds <= 60)) {
			return "{$seconds}秒前";
		}
		if (($minutes >= 0) && ($minutes <= 60)) {
			return "{$minutes}分钟前";
		}
		if (($hours >= 0) && ($hours <= 24)) {
			return "{$hours}小时前";
		}
		if ((date('Y') - date('Y', $from)) > 0) {
			return date('Y-m-d', $from);
		}

		switch ($day) {
			case 0:
				return date('今天H:i', $from);
				break;

			case 1:
				return date('昨天H:i', $from);
				break;

			default:
				return "{$day} 天前";
				break;
		}
	}
}

/**
 * 过滤二维数组中重复的数组(以数组中某个键值为判断)
 *
 * @param array $array
 * @param       $key
 *
 * @return array
 */
if (!function_exists('array_filter_repeat')) {
	function array_filter_repeat($array, $key)
	{
		$i          = 0;
		$temp_array = [];
		$key_array  = [];

		foreach ($array as $val) {
			if (!in_array($val[$key], $key_array)) {
				$key_array[$i]  = $val[$key];
				$temp_array[$i] = $val;
			}
			$i++;
		}

		return $temp_array;
	}
}

/**
 * 校验是否为中国手机号码
 *
 * @param string $number
 *
 * @return bool
 */
if (!function_exists('is_phone_number')) {
	function is_phone_number(string $number): bool
	{
		return preg_match('/^(\+?0?86\-?)?((13\d|14[57]|15[^4,\D]|17[3678]|18\d)\d{8}|170[059]\d{7})$/', $number);
	}
}

/**
 * 校验是否为有效的用户名
 *
 * @param string $number
 *
 * @return bool
 */
if (!function_exists('is_valid_name')) {
	function is_valid_name(string $name): bool
	{
		return preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name);
	}
}

/**
 * 将数组键值出现的'_'用'.'替代
 *
 * @param array $array
 *
 * @return array
 */
if (!function_exists('array_key_to_dot')) {
	function array_key_to_dot(array $array)
	{
		foreach ($array as $key => $value) {
			if (strpos($key, '_') !== false) {
				$key         = str_replace('_', '.', $key);
				$array[$key] = $value;
			}
		}

		return $array;
	}
}