<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tenants';

    protected $primaryKey = 'id';

    protected $fillable = [
        'paper_id',
        'name',
        'email',
        'phone',
        'company',
        'floor',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, "tenant_id");
    }

    public function receipts(): HasMany
    {
        return $this->hasMany(Receipt::class, "tenant_id");
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, "tenant_id");
    }

    public function purchaseOrder(): HasOne
    {
        return $this->hasOne(PurchaseOrder::class, "tenant_id");
    }
}
