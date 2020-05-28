<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 26.05.2020
 * Time: 15:55
 */

namespace common\dispatchers;


use common\events\Event;

interface EventDispatcherInterface
{
    public function dispatch(Event $event);
}