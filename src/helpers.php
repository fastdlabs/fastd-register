<?php
/**
 * Created by PhpStorm.
 * User: yong
 * Date: 2018/6/19
 * Time: 10:40
 */

if(!function_exists('registry')) {
    /**
     * @return \Registry\Registry
     */
    function registry()
    {
        return app()->get('registry');
    }
}