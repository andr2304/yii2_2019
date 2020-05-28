<?php
namespace common\bootstrap;
use common\dispatchers\SimpleDispatcherEvent;
use Yii;
use yii\base\BootstrapInterface;
use yii\di\Container;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app): void
    {
        $container = Yii::$container;

        $container->setSingleton('common\dispatchers\EventDispatcherInterface', function (Container $container){
            return new SimpleDispatcherEvent([
                'common\events\shop\CreateTagEvent' => ['common\listeners\shop\CreateTagListener']
            ]);
        });
    }
}