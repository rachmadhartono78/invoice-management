<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DamageReport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'damage_reports';

    protected $primaryKey = 'id';

    protected $fillable = [
        "damage_report_number",
        "scope",
        "classification",
        "damage_report_date",
        "action_plan_date",
        "status",
        "ticket_id",
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

        $maxNumberForYear = static::whereYear('created_at', $year)->max('damage_report_number') ?: 0;

        $this->damage_report_number = str_pad($maxNumberForYear + 1, 5, '0', STR_PAD_LEFT);
    }

    public function damageReportDetails(): HasMany
    {
        return $this->hasMany(DamageReportDetail::class, "damage_report_id");
    }

    public function damageReportSignatures(): HasMany
    {
        return $this->hasMany(DamageReportSignature::class, "damage_report_id");
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, "ticket_id");
    }
}
