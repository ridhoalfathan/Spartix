<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is owner
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get user's photo URL
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=2D5BFF&background=DBEAFE';
    }

    /**
     * Get user's initials
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * Get role badge color
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            'owner' => 'bg-purple-500',
            'admin' => 'bg-blue-500',
            default => 'bg-gray-500',
        };
    }

    /**
     * Get role display name
     */
    public function getRoleNameAttribute(): string
    {
        return match($this->role) {
            'owner' => 'Owner',
            'admin' => 'Admin',
            default => 'Unknown',
        };
    }
}