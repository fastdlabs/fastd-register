<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/19
 * Time: 10:40
 */

if (!function_exists('registry')) {
    /**
     * @return \Registry\Registry
     */
    function registry()
    {
        return app()->get('registry');
    }
}

if (!function_exists('validator')) {
    /**
     * @param $data
     * @return array
     * @throws Exception
     */
    function validator($data, $rules = null)
    {
        is_null($rules) && $rules = [
            'service_host' => 'required|url',
            'service_name' => 'required|string',
            'service_pid' => 'required|numeric',
        ];

        $validator = new \Runner\Validator\Validator($data, $rules);

        if (!$validator->validate()) {
            $messages = '';
            foreach ($validator->messages() as $fieldMessages) {
                $messages .= implode(';', $fieldMessages) . ';';
            }
            abort('invalid parameter', $messages);
        }

        return $validator->data();
    }
}
