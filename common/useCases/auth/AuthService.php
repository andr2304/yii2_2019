<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 01.04.2020
 * Time: 13:39
 */

namespace common\useCases\auth;

use common\entities\User;
use common\forms\LoginForm;
use common\Reposetories\auth\UserRepository;
use frontend\forms\SignupForm;

class AuthService
{
    private $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function login(LoginForm $form)
    {
        $user = $this->user->findByUsernameOrEmail($form->username);

        if(!$user || !$user->validatePassword($form->password)) {
            throw new \DomainException("Incorrect username or password.");
        }

        return $user;
    }

    public function signup(SignupForm $form)
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
        );

        $this->user->save($user);

        return $user;
    }
}