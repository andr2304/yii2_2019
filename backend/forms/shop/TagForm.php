<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:11
 */

namespace backend\forms\shop;


use common\entities\shop\Tag;
use yii\base\Model;

class TagForm extends Model
{
    public $name;
    public $slug;

    public $_tag;

    public function __construct(Tag $tag = null, array $config = [])
    {
        if($tag){
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', 'match', 'pattern' => '#^[a-z0-9_-]*$#s'],
            [['name', 'slug'], 'unique', 'targetClass' => Tag::class, 'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : null]
        ];
    }
}