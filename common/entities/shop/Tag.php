<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:08
 */

namespace common\entities\shop;


use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 */

class Tag extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $tag = new static();
        $tag->name = $name;
        $tag->slug = $slug;
        return $tag;
    }

    public function edit($name, $slug): void
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function tableName()
    {
        return '{{%shop_tags}}';
    }
}