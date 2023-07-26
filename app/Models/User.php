<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        "roles" => 'json',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        "roles" => '[]',
    ];

    /**
     * Create a new personal access token for the user.
     */
    public function createToken(string $name, array $abilities = ['*'], DateTimeInterface $expiresAt = null): NewAccessToken
    {
        $tokens = $this->tokens();

        /** @var PersonalAccessToken $access_token */
        $access_token = $tokens->where('name', $name)->first();

        if ($access_token) {
            $access_token['token'] = hash('sha256', $plainTextToken = Str::random(40));
            $access_token['abilities'] = $abilities;
            $access_token['expires_at'] = $expiresAt;
        } else {
            $access_token = $this->tokens()->create([
                'name' => $name,
                'token' => hash('sha256', $plainTextToken = Str::random(40)),
                'abilities' => $abilities,
                'expires_at' => $expiresAt,
            ]);
        }

        return new NewAccessToken($access_token, $access_token->getKey() . '|' . $plainTextToken);
    }
}
