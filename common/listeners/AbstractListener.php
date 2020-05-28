<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 26.05.2020
 * Time: 16:07
 */

namespace common\listeners;

abstract class AbstractListener
{
    abstract public function handle($event);
}