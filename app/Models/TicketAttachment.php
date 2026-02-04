<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketAttachment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ticket_attachments';

    protected $primaryKey = 'id';

    protected $fillable = [
        "ticket_id",
        "attachment",
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $timestamp = true;

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class, "ticket_id");
    }
}
