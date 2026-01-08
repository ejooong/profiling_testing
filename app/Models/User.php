<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'photo',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    // Relasi dengan kader
    public function kader()
    {
        return $this->hasOne(Kader\Kader::class, 'user_id');
    }

    // Relasi dengan berita
    public function beritas()
    {
        return $this->hasMany(Berita\Berita::class, 'user_id');
    }

    // Cek apakah user adalah penulis berita
    public function isNewsWriter()
    {
        return $this->hasRole('news-writer') || $this->hasRole('admin');
    }

    // Cek apakah user adalah admin DPD
    public function isDpdAdmin()
    {
        return $this->hasRole('dpd-admin') || $this->hasRole('super-admin');
    }

    // Cek apakah user adalah admin DPC
    public function isDpcAdmin()
    {
        return $this->hasRole('dpc-admin') || $this->hasRole('dpd-admin') || $this->hasRole('super-admin');
    }
}