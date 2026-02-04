<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scope extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'scopes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;
}
