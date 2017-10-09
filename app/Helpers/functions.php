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
