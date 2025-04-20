<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'role_name'
    ];
    public function users(){
        return $this->belongsToMany(User::class,'role_user');
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }
//    public function isAdmin(): bool
//    {
//        return $this->role_name == 'admin';
//    }
    public function hasPermission(string $permission):bool
    {
        return $this->permissions()->where('name',$permission)->exists();
    }
}
