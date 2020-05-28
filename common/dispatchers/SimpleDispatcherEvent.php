<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 26.05.2020
 * Time: 16:28
 */

namespace common\dispatchers;


use common\events\Event;

class SimpleDispatcherEvent implements EventDispatcherInterface
{
    public $listeners = [];

    public function __construct(array $listeners)
    {
        $this->listeners = $listeners;
    }

    public function dispatch(Event $event)
    {
        $eventName = get_class($event);
        if (isset($this->listeners[$eventName])) {
            foreach ($this->listeners[$eventName] as $listenerClass) {
                call_user_func([\Yii::createObject($listenerClass), 'handle'], $event);
            }
        }
    }
}