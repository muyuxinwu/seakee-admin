<?php
/**
 * File: ValidatorService.php
 * Author: Seakee <seakee23@163.com>
 * Date: 2017/6/12 10:35
 * Description:
 */

namespace App\Services;

use Validator;

class ValidatorService
{
    /**
     * Get a validator for an incoming request, and return Validation messages.
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @return array|null
     */
    public function validate(array $data, array $rules, array $messages)
    {
        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            $messages = $validator->messages()->setFormat('');

            foreach ($messages->getMessages() as $k => $v) {
                $error = [$v[0]];
                return ['status' => 500, 'message' => $error];
            }
        }

        return NULL;
    }
}