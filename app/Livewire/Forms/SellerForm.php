<?php

namespace App\Livewire\Forms;

use App\Enums\RoleEnum;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Validation\Rules;

class SellerForm extends Form
{

    public Seller $seller;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public $role_id = RoleEnum::MANAGER->value;

    public function setSeller(Seller $seller)
    {
        $this->seller = $seller;
        if (!empty($seller->user)) {
            $this->name = $seller->user->name;
            $this->email = $seller->user->email;
            $this->role_id = $seller->user->role_id;
        }
    }

    public function store() {

        $emailValidations = ['required', 'email', 'unique:users'];

        if (!empty($this->seller->user)) {
            $emailValidations = ['required', 'email', Rule::unique('users')->ignore($this->seller->user_id)];
        }

        $this->validate([
            'name' => 'required|min:3',
            'email' => $emailValidations,
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        if (!empty($this->seller->user)) {
            User::update($this->only(['name', 'email', 'password', 'role_id']));

        } else {
            User::create($this->only(['name', 'email', 'password', 'role_id']))
                ->seller()->create();
        }
    }
}
