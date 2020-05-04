<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:23
 */

namespace common\useCases\manage\shop;

use backend\forms\shop\Product\ProductCreateForm;
use backend\forms\shop\Product\ProductEditForm;
use common\entities\Meta;
use common\entities\shop\product\Product;
use common\entities\shop\Tag;
use common\helpers\DebugHelper;
use common\Reposetories\shop\BrandRepository;
use common\Reposetories\shop\CategoryRepository;
use common\Reposetories\shop\ProductRepository;
use common\Reposetories\shop\TegRepository;

class ProductService
{
    private $products;
    private $brands;
    private $categories;
    private $tags;

    public function __construct(
        ProductRepository $products,
        BrandRepository $brands,
        CategoryRepository $categories,
        TegRepository $tags
    )
    {
        $this->products = $products;
        $this->brands = $brands;
        $this->categories = $categories;
        $this->tags = $tags;
    }

    public function create(ProductCreateForm $form): Product
    {
        $brand = $this->brands->get($form->brandId);
        $category = $this->categories->get($form->categories->main);

        $product = Product::create(
            $brand->id,
            $category->id,
            $form->code,
            $form->name,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $product->setPrice($form->price->new, $form->price->old);

        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }

        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $product->assignTag($tag->id);
        }

        foreach ($form->tags->newNames as $tagName) {
            if (!$tag = $this->tags->findByName($tagName)) {
                $tag = Tag::create($tagName, $tagName);
                $this->tags->save($tag);
            }
            $product->assignTag($tag->id);
        }

        $this->products->save($product);

        return $product;
    }

    public function edit($id, ProductEditForm $form):void
    {
        $product = $this->products->get($id);
        $brand = $this->brands->get($form->brandId);
        $category = $this->categories->get($form->categories->main);

        $product->edit(
            $brand->id,
            $category->id,
            $form->code,
            $form->name,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $product->changeMainCategory($category->id);

        $product->revokeTags();
        $product->revokeCategories();

        $this->products->save($product);

        foreach ($form->categories->others as $otherId) {
            $category = $this->categories->get($otherId);
            $product->assignCategory($category->id);
        }

        foreach ($form->tags->existing as $tagId) {
            $tag = $this->tags->get($tagId);
            $product->assignTag($tag->id);
        }

        foreach ($form->tags->newNames as $tagName) {
            if (!$tag = $this->tags->findByName($tagName)) {
                $tag = Tag::create($tagName, $tagName);
                $this->tags->save($tag);
            }
            $product->assignTag($tag->id);
        }

        $this->products->save($product);
    }

    public function remove($id): void
    {
        $product = $this->products->get($id);
        $this->products->remove($product);
    }
}