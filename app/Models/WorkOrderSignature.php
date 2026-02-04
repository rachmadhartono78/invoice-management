<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrderSignature extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'work_order_signature';

    protected $primaryKey = 'id';

    protected $fillable = [
        "work_order_id",
        "position",
        "name",
        "signature",
        "date",
        "deleted_at",
    ];

    public $timestamp = true;

    public function workOrder(): BelongsTo
    {
        return $this->BelongsTo(WorkOrder::class, "work_order_id");
    }
}
