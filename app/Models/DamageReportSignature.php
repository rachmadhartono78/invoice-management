<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DamageReportSignature extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'damage_report_signature';

    protected $fillable = [
        "damage_report_id",
        "type",
        "name",
        "signature",
        "date",
        "deleted_at",
    ];

    public $timestamp = true;

    public function damageReport(): BelongsTo
    {
        return $this->belongsTo(DamageReport::class, "damage_report_id");
    }
}
