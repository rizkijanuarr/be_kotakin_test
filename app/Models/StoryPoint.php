<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class StoryPoint extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use UUID;
    use AuditableTrait;

    protected $table = 'story_points';

    protected $fillable = [
        'name',
        'value',
        'hours',
        'is_active'
    ];

    protected $auditEvents = ['created','updated','deleted'];

    public function todos()
    {
        return $this->hasMany(\App\Models\Todo::class);
    }
}
