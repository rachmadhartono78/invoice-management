<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'work_orders';

    protected $primaryKey = 'id';

    protected $fillable = [
        "work_order_number",
        "scope",
        "classification",
        "work_order_date",
        "action_plan_date",
        "status",
        "damage_report_id",
        "finish_plan",
        "job_description",
        "klasifikasi",
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

        $maxNumberForYear = static::whereYear('created_at', $year)->max('work_order_number') ?: 0;

        $this->work_order_number = str_pad($maxNumberForYear + 1, 5, '0', STR_PAD_LEFT);
    }

    public function workOrderDetails(): HasMany
    {
        return $this->hasMany(WorkOrderDetail::class, "work_order_id");
    }

    public function workOrderSignatures(): HasMany
    {
        return $this->hasMany(WorkOrderSignature::class, "work_order_id");
    }
}
