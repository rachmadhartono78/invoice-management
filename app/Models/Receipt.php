<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'receipts';

    protected $primaryKey = 'id';

    protected $fillable = [
        "receipt_number",
        "grand_total",
        "receipt_date",
        "receipt_send_date",
        "tenant_id",
        "invoice_id",
        "status",
        "check_number",
        "bank_id",
        "paid",
        "remaining",
        "grand_total_spelled",
        "note",
        "signature_date",
        "signature_image",
        "signature_name",
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->resetYearlyNumber();
    }

    public function resetYearlyNumber()
    {
        $year = now()->year;

        $maxNumberForYear = static::whereYear('created_at', $year)->max('receipt_number') ?: 0;

        $this->receipt_number = str_pad($maxNumberForYear + 1, 5, '0', STR_PAD_LEFT);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, "invoice_id");
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, "bank_id");
    }
}
