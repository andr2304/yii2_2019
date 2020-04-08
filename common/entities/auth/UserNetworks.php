<?php

namespace common\entities\auth;

use common\entities\User;
use Webmozart\Assert\Assert;
use Yii;

/**
 * This is the model class for table "user_networks".
 *
 * @property int $id
 * @property int $user_id
 * @property string $identity
 * @property string $network
 *
 * @property User $user
 */
class UserNetworks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_networks';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'identity' => 'Identity',
            'network' => 'Network',
        ];
    }

    public static function create($userNetwork, $identity)
    {
        Assert::notEmpty($userNetwork);
        Assert::notEmpty($identity);

        $network = new static();
        $network->network = $userNetwork;
        $network->identity = $identity;

        return $network;
    }

    public function isFor($userNetwork, $identity)
    {
        return $this->network === $userNetwork && $this->identity === $identity;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
