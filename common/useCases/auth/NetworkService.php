<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 07.04.2020
 * Time: 15:14
 */

namespace common\useCases\auth;


use common\entities\User;
use common\Reposetories\auth\UserRepository;

class NetworkService
{
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function auth($network, $identity) :User
    {
        $user = $this->user->findByNetwork($network, $identity);
        if(!empty($user)){
            return $user;
        }
        $user = User::signUpByNetwork($network, $identity);
        $this->user->save($user);
        return $user;
    }

    public function attach($id, $network, $identity) :User
    {
        $user = $this->user->findByNetwork($network, $identity);
        if(!empty($user)){
            throw new \DomainException('Already exist');
        }
        $user = User::findOne($id);
        $user->attachUserByNetwork($network, $identity);
        $this->user->save($user);
    }
}