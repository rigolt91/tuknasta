<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $user = User::where('email', $input['email'])->first();

        if($user)
        {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string','max:255'],
                'email' => 'required', 'string', 'email', 'max:255',
                'password' => $this->passwordRules(),
            ]);

            $user->update([
                'name' => $input['name'],
                'last_name' => $input['last_name'],
                'email_verified_at' => null,
                'password' => Hash::make($input['password']),
            ]);
        } else {
            Validator::make($input, [
                'name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string','max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
                'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            ])->validate();

            $user = User::create([
                'name' => $input['name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            $user->assignRole('customer');
        }

        return $user;
    }
}
