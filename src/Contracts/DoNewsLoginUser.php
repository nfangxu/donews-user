<?php
/**
 * Created by PhpStorm.
 * User: nfangxu
 * Date: 2018/9/28
 * Time: 14:01
 */

namespace Fangxu\Donews\Contracts;


interface DoNewsLoginUser
{
    public function id();

    public function info();
}