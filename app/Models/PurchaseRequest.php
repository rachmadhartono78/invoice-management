<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'purchase_requests';

    protected $primaryKey = 'id';

    protected $fillable = [
        "purchase_request_number",
        "department_id",
        "proposed_purchase_price",
        "budget_status",
        "request_date",
        "status",
        "requester",
        "total_budget",
        "remaining_budget",
        "material_request_id",
        "additional_note",
        "deleted_at",
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

        $maxNumberForYear = static::whereYear('created_at', $year)->max('purchase_request_number') ?: 0;

        $this->purchase_request_number = str_pad($maxNumberForYear + 1, 5, '0', STR_PAD_LEFT);
    }

    public function department(): BelongsTo
    {
        return $this->BelongsTo(Department::class, "department_id");
    }

    public function materialRequest(): BelongsTo
    {
        return $this->BelongsTo(MaterialRequest::class, "material_request_id");
    }

    public function purchaseRequestDetails(): HasMany
    {
        return $this->hasMany(PurchaseRequestDetail::class, "purchase_request_id");
    }

    public function purchaseRequestSignatures(): HasMany
    {
        return $this->hasMany(PurchaseRequestSignature::class, "purchase_request_id");
    }
}
