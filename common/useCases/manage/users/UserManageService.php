<?php
/**
 * Created by PhpStorm.
 * User: Boss
 * Date: 08.04.2020
 * Time: 13:12
 */

namespace common\useCases\manage\users;


use backend\forms\users\CreateUserForm;
use backend\forms\users\UserEditForm;
use common\entities\User;
use common\Reposetories\auth\UserRepository;

class UserManageService
{
    public $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function create(CreateUserForm $form)
    {
        $user = User::createByAdmin(
            $form->username,
            $form->email,
            $form->password
        );

        $this->user->save($user);

        return $user;
    }

    public function edit(UserEditForm $form, User $user)
    {
        $user->edit(
            $form->username,
            $form->email
        );

        $this->user->save($user);

        return $user;
    }
}