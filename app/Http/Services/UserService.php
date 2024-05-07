<?php
namespace App\Http\Services;


use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function profile(User $user): User
    {
        $auth_user = Auth::user();
        if(($auth_user['id'] != $user['id']) && ($auth_user->role->name != Role::ROLE_ADMIN)){
            throw ValidationException::withMessages([
                'auth' => ['Нет доступа к данным профиля!'],
            ]);
        }
        return $user->load('orders')->load('orders.products');
    }
}
