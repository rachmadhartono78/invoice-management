<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vendors';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'email',
        'pic',
        'phone',
        'address',
        'floor',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;

    public function purchaseOrder(): HasOne
    {
        return $this->hasOne(PurchaseOrder::class, "vendor_id");
    }
}
