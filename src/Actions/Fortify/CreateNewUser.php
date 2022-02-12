<?php

namespace jobvink\tools\Actions\Fortify;

use jobvink\tools\Actions\Fortify\PasswordValidationRules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use jobvink\tools\Events\UserRegistered;
use jobvink\tools\Models\FlashMessage;
use jobvink\tools\Models\User;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
        ]);

        event(new UserRegistered($user));

        session()->flash('toast', [new FlashMessage(FlashMessage::SUCCESS, 'De gebruiker met de naam ' . $user->name . ' Heeft een email ontvangen, deze is 24 uur geldig.')]);

        return $user;
    }
}
