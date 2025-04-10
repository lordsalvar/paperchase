<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'deactivated_at',
        'deactivated_by',
        'change_password',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'deactivated_at' => 'datetime',
        ];
    }

    public function deactivate(User $byUser): void
    {
        $this->update([
            'deactivated_at' => now(),
            'deactivated_by' => $byUser->id,
        ]);
    }

    public function reactivate(): void
    {
        $this->update([
            'deactivated_at' => null,
            'deactivated_by' => null,
        ]);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar
            ? asset('storage/'.$this->avatar)
            : null; // You can also return a default avatar if no image is available
    }
}
