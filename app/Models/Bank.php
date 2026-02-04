<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'banks';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'account_name',
        'account_number',
        'branch_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, "bank_id");
    }
}
