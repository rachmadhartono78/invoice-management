<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'work_order_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        "work_order_id",
        "location",
        "material_request",
        "type",
        "quantity",
        "deleted_at",
    ];

    public $timestamp = true;

    public function workOrder(): BelongsTo
    {
        return $this->BelongsTo(WorkOrder::class, "work_order_id");
    }
}
