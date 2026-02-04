<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialRequestDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'material_request_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        "material_request_id",
        "number",
        "part_number",
        "description",
        "quantity",
        "stock",
        "stock_out",
        "end_stock",
        "min_stock",
        "deleted_at",
    ];

    public $timestamp = true;

    public function materialRequest(): BelongsTo
    {
        return $this->BelongsTo(MaterialRequest::class, "material_request_id");
    }
}
