<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequestDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'purchase_request_detail';

    protected $primaryKey = 'id';

    protected $fillable = [
        "purchase_request_id",
        "number",
        "part_number",
        "last_buy_date",
        "last_buy_quantity",
        "last_buy_stock",
        "description",
        "quantity",
        "deleted_at",
    ];

    public $timestamp = true;

    public function purchaseRequest(): BelongsTo
    {
        return $this->BelongsTo(PurchaseRequest::class, "purchase_request_id");
    }
}
