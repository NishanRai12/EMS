<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'password',
        'role'
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
        ];
    }
//    public function categories()
//    {
//        return $this->hasMany(Category::class);
//    }
    public function monthlyBudgets()
    {
        return $this->hasMany(MonthlyBudget::class);
    }
    public function expenses(){
        return $this->hasMany(Expenses::class);
    }
    public function categories(){
        return $this->belongsToMany(Category::class)->withPivot('percentage','month');
    }
    public function fullname(){
        return $this->first_name . ' ' . $this->last_name;
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    public function getRole(): ?Role
    {
        return $this->roles()->first(); // Get the first associated role
    }
    public function isAdmin(): bool
    {
        return $this->roles()->where('role_name', 'admin')->exists(); // Check if the user has 'admin' role
    }
}

