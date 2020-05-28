<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 09.04.2020
 * Time: 12:23
 */

namespace common\useCases\manage\shop;


use backend\forms\shop\TagForm;
use common\dispatchers\EventDispatcherInterface;
use common\entities\shop\Tag;
use common\events\shop\CreateTagEvent;
use common\Reposetories\shop\TegRepository;

class TagService
{
    public $repository;
    public $dispatcher;

    public function __construct(TegRepository $repository, EventDispatcherInterface $dispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function create(TagForm $form):Tag
    {
        $tag = Tag::create(
            $form->name,
            $form->slug
        );
        $this->repository->save($tag);
        $this->dispatcher->dispatch(new CreateTagEvent($tag));
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