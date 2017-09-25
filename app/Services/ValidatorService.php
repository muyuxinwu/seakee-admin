<?php
/**
 * File: ValidatorService.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/6/12 10:35
 * Description:Validator Service
 */

namespace App\Services;

use Validator;

class ValidatorService
{
	/**
	 * Get a validator for an incoming request, and return all Validation messages.
	 *
	 * @param array $data
	 * @param array $rules
	 * @param array $messages
	 *
	 * @return array|null
	 */
	public function allError(array $data, array $rules, array $messages)
	{
		$validator = Validator::make($data, $rules, $messages);

		if ($validator->fails()) {
			$messages = $this->formatValidationErrors($validator);

			return [
				'status'  => 500,
				'message' => $messages,
			];
		}

		return NULL;
	}

	/**
	 * Get a validator for an incoming request, and return the first Validation message.
	 *
	 * @param array $data
	 * @param array $rules
	 * @param array $messages
	 *
	 * @return array|null
	 */
	public function firstError(array $data, array $rules, array $messages)
	{
		$validator = Validator::make($data, $rules, $messages);

		if ($validator->fails()) {
			$messages = head($this->formatValidationErrors($validator));

			return [
				'status'  => 500,
				'message' => $messages[0],
			];
		}

		return NULL;
	}

	/**
	 * Format the validation errors to be returned.
	 *
	 * @param Validator $validator
	 *
	 * @return mixed
	 */
	protected function formatValidationErrors($validator)
	{
		return $validator->errors()->getMessages();
	}
}