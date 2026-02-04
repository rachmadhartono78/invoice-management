<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'departments';

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
        return $this->hasMany(User::class, "department_id");
    }

    public function purchaseRequests(): HasMany
    {
        return $this->hasMany(PurchaseRequest::class, "department_id");
    }
}
