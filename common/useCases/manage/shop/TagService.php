<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:23
 */

namespace common\useCases\manage\shop;


use backend\forms\shop\TagForm;
use common\entities\shop\Tag;
use common\Reposetories\shop\TegRepository;

class TagService
{
    public $repository;

    public function __construct(TegRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(TagForm $form):Tag
    {
        $tag = Tag::create(
            $form->name,
            $form->slug
        );
        $this->repository->save($tag);
        return $tag;
    }

    public function edit($id, TagForm $form):void
    {
        $tag = $this->repository->get($id);
        $tag->edit(
            $form->name,
            $form->slug
        );
        $this->repository->save($tag);
    }

    public function remove($id): void
    {
        $tag = $this->repository->get($id);
        $this->repository->remove($tag);
    }
}