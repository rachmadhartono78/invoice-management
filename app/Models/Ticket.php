<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tickets';

    protected $primaryKey = 'id';

    protected $fillable = [
        "ticket_number",
        "reporter_name",
        "reporter_phone",
        "tenant_id",
        "ticket_title",
        "ticket_body",
        "status",
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

        $maxNumberForYear = static::whereYear('created_at', $year)->max('ticket_number') ?: 0;

        $this->ticket_number = str_pad($maxNumberForYear + 1, 5, '0', STR_PAD_LEFT);
    }

    public function ticketAttachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class, "ticket_id");
    }

    public function damageReport(): HasOne
    {
        return $this->hasOne(DamageReport::class, "ticket_id");
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }
}
