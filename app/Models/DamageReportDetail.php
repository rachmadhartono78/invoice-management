<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DamageReportDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'damage_report_detail';

    protected $fillable = [
        "damage_report_id",
        "category",
        "location",
        "total",
        "deleted_at",
    ];

    public $timestamp = true;

    public function damageReport(): BelongsTo
    {
        return $this->belongsTo(DamageReport::class, "damage_report_id");
    }
}
