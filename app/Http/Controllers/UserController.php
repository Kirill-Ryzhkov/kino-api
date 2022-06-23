<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Метод для создания пользователя user, с email - hey@gmai.com, пароль - hello123.
     * Метод нужен для последующей oauth авторизации
     * @author Kirill Ryzhkov <slusc10a@gmail.com>
     * @param none
     * @return void
     * @example localhost:8000/user
     */
    public function makeUser(){
        $user = new User;
        $user->name = 'user';
        $user->email = 'hey@gmail.com';
        $user->password = Hash::make('hello123');
        $user->save();
    }
}
