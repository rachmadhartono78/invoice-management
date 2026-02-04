<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'classifications';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;
}
