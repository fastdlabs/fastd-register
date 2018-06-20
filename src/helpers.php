<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/19
 * Time: 10:40
 */

use Support\Registry\Registry;

if(!function_exists('registry')) {
    /**
     * @return Registry
     */
    function registry()
    {
        return new Registry();
    }
}