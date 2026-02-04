<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequestSignature extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'purchase_request_signature';

    protected $primaryKey = 'id';

    protected $fillable = [
        "purchase_request_id",
        "type",
        "name",
        "signature",
        "date",
        "deleted_at",
    ];

    public $timestamp = true;

    public function purchaseRequest(): BelongsTo
    {
        return $this->BelongsTo(PurchaseRequest::class, "purchase_request_id");
    }
}
