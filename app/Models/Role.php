<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UUID;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'is_active'
    ];

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
