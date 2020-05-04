<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 21.04.2020
 * Time: 12:14
 */

namespace backend\forms\shop\Product;


use common\entities\shop\product\Product;
use yii\base\Model;

class PriceForm extends Model
{
    public $old;
    public $new;

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->new = $product->price_new;
            $this->old = $product->price_old;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['new'], 'required'],
            [['old', 'new'], 'integer', 'min' => 0],
        ];
    }
}

