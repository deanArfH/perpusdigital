<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class CustomLogin extends BaseLogin
{
    public function hasLogo(): bool
    {
        return false;
    }

    public function getHeading(): string | Htmlable | null
    {
        return new HtmlString(view('filament.pages.auth.custom-login-header')->render());
    }

    public function getSubheading(): string | Htmlable | null
    {
        return new HtmlString('
            <div style="text-align: center; margin-top: 4px;">
                <span class="dark:text-gray-400" style="color: #6B7280; font-size: 14px;">Belum punya akun?</span> 
                <a href="/siswa/register" style="color: #4F46E5; font-weight: 600; text-decoration: none; margin-left: 4px;">Daftar di sini</a>
            </div>
        ');
    }

    protected function throwFailureValidationException(): never
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'data.password' => __('Password yang Anda masukkan salah atau email tidak terdaftar.'),
        ]);
    }
}
