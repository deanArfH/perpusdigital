<?php

namespace App\Filament\Siswa\Pages;

use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama lengkap wajib diisi.',
                    ])
                    ->maxLength(255)
                    ->autofocus(),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->unique('users', 'username')
                    ->validationMessages([
                        'required' => 'Username wajib diisi.',
                        'unique' => 'Username ini sudah dipakai oleh orang lain.',
                    ])
                    ->maxLength(255)
                    ->alphaNum(),
                $this->getEmailFormComponent()
                    ->label('Email')
                    ->validationMessages([
                        'required' => 'Email wajib diisi.',
                        'unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk (login).',
                        'email' => 'Format email tidak valid.',
                    ]),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Password')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->validationMessages([
                'required' => 'Password wajib diisi.',
            ])
            ->rule(\Illuminate\Validation\Rules\Password::default())
            ->dehydrateStateUsing(fn ($state) => \Illuminate\Support\Facades\Hash::make($state));
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('passwordConfirmation')
            ->label('Konfirmasi Password')
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->same('password')
            ->validationMessages([
                'required' => 'Konfirmasi password wajib diisi.',
                'same' => 'Konfirmasi password tidak cocok dengan password di atas.',
            ])
            ->dehydrated(false);
    }

    protected function handleRegistration(array $data): Model
    {
        $data['role'] = 'siswa';

        return $this->getUserModel()::create($data);
    }
}
