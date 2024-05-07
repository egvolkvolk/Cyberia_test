<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(){
        return User::get()-> load('role');
    }

    //2|D24ReDi3Xs8a2E7SCMNdwfj1rad8qrg09v7dOasjb40c64cc user
    //3|FkBcKx3DJjtuNofObLlOdNFoz1q0kfrpd5GR5SRY9ead04a3 admin

    /**
     * @throws ValidationException
     */
    public function profile(User $user, UserService $userService): User
    {
        return $userService->profile($user);
    }
}
