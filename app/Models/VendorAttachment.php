<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorAttachment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'vendor_attachments';

    protected $primaryKey = 'id';

    protected $fillable = [
        "purchase_order_id",
        "uraian",
        "attachment",
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, "purhcase_order_id");
    }
}
