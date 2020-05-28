<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 26.05.2020
 * Time: 16:10
 */

namespace common\listeners\shop;

use common\events\shop\CreateTagEvent;

class CreateTagListener
{
    public function handle(CreateTagEvent $event)
    {
        \Yii::info($event->getLogMessage(). $event->tag->id);
    }
}