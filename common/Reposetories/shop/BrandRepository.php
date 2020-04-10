<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 15:59
 */

namespace common\Reposetories\shop;


use common\entities\shop\Brand;

class BrandRepository
{
    public function get($id): Brand
    {
        if (!$brand = Brand::findOne($id)) {
            throw new \RuntimeException('Brand is not found.');
        }
        return $brand;
    }

    public function save(Brand $brand): void
    {
        if (!$brand->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove(Brand $brand): void
    {
        if (!$brand->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}