<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, Auditable
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use UUID;
    use AuditableTrait;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active'
    ];

    protected $auditEvents = ['created','updated','deleted'];

    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    public function todos()
    {
        return $this->hasMany(\App\Models\Todo::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => strtoupper($value),
        );
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
