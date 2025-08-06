<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Todo extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use UUID;
    use AuditableTrait;

    protected $table = 'todos';

    protected $fillable = [
        'user_id',
        'status_id',
        'story_point_id',
        'title',
        'description',
        'image',
        'file',
        'link',
        'code',
        'is_active',
    ];

    protected $casts = [
        'code' => 'array',
    ];

    # AUDIT
    protected $auditEvents = [
        'created',
        'updated',
        'deleted',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function status()
    {
        return $this->belongsTo(\App\Models\Status::class);
    }

    public function storyPoint()
    {
        return $this->belongsTo(\App\Models\StoryPoint::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? url('/storage/' . ltrim($value, '/')) : null,
        );
    }

    protected function file(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? url('/storage/' . ltrim($value, '/')) : null,
        );
    }
}
