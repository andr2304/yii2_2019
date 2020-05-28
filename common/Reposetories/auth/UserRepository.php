<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 01.04.2020
 * Time: 13:42
 */

namespace common\Reposetories\auth;


use common\entities\User;

class UserRepository
{
    public function findByUsernameOrEmail($username): ?User
    {
        return  User::find()->andWhere(['or', ['username' => $username], ['email' => $username]])
            ->andWhere(['status'=>User::STATUS_ACTIVE])->one();
    }

    public function findByNetwork($network, $identity): ?User
    {
        return  User::find()->joinWith('userNetworks n')->andWhere(['n.network' => $network, 'n.identity' => $identity])->one();
    }

    public function save(User $user)
    {
        if(!$user->save()){
            throw new \RuntimeException('Saving error');
        }
    }
}