<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialRequest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'material_requests';

    protected $primaryKey = 'id';

    protected $fillable = [
        "material_request_number",
        "requester",
        "department",
        "request_date",
        "status",
        "stock",
        "purchase",
        "note",
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

        $maxNumberForYear = static::whereYear('created_at', $year)->max('material_request_number') ?: 0;

        $this->material_request_number = str_pad($maxNumberForYear + 1, 5, '0', STR_PAD_LEFT);
    }

    public function materialRequestDetails(): HasMany
    {
        return $this->hasMany(MaterialRequestDetail::class, "material_request_id");
    }

    public function materialRequestSignatures(): HasMany
    {
        return $this->hasMany(MaterialRequestSignature::class, "material_request_id");
    }

    public function purchaseRequest(): HasOne
    {
        return $this->hasOne(PurchaseRequest::class, "material_request_id");
    }

}
