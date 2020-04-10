<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:23
 */

namespace common\useCases\manage\shop;


use backend\forms\shop\BrandForm;
use common\entities\Meta;
use common\entities\shop\Brand;
use common\Reposetories\shop\BrandRepository;

class BrandService
{
    public $repository;

    public function __construct(BrandRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(BrandForm $form):Brand
    {
        $brand = Brand::create(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->repository->save($brand);
        return $brand;
    }

    public function edit($id, BrandForm $form):void
    {
        $brand = $this->repository->get($id);
        $brand->edit(
            $form->name,
            $form->slug,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );
        $this->repository->save($brand);
    }

    public function remove($id): void
    {
        $brand = $this->repository->get($id);
        $this->repository->remove($brand);
    }
}