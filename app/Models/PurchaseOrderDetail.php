<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'purchase_order_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        "purchase_order_id",
        "number",
        "name",
        "specification",
        "quantity",
        "units",
        "price",
        "tax_id",
        "total_price",
        "deleted_at",
    ];

    public $timestamp = true;

    public function purchaseOrder(): BelongsTo
    {
        return $this->BelongsTo(PurchaseOrder::class, "purchase_order_id");
    }

}
