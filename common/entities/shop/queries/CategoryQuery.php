<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 10.04.2020
 * Time: 10:38
 */

namespace common\entities\shop\queries;


use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;
}