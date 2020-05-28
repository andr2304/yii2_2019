<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 26.05.2020
 * Time: 16:02
 */

namespace common\events\shop;


use common\entities\shop\Tag;
use common\events\Event;

class CreateTagEvent extends Event
{
    public $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function getLogMessage()
    {
        return 'Create tag id - ';
    }
}