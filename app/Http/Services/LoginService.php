<?php
namespace App\Http\Services;

use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginService
{
    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): array
    {
        $user = User::where('email', $request->getEmail())->first();

       if(! $user || ! Hash::check($request->getPsswrd(), $user->password))
       {
           throw ValidationException::withMessages([
               'email' => ['Данные неверные!'],
           ]);
       }

       return match ($user->role->name)
       {
           Role::ROLE_ADMIN => ['token' => $user->createToken($user->name, ['ability:admin'])->plainTextToken],
           Role::ROLE_USER => ['token' => $user->createToken($user->name, ['ability:user'])->plainTextToken],
       };

    }
}
