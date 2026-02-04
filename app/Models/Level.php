<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'levels';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;

    public function users(): HasMany
    {
        return $this->hasMany(User::class, "level_id");
    }
}
