<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'taxes';

    protected $primaryKey = 'id';

    protected $fillable = [
        "id",
        "name",
        "rate",
        "description",
        "deleted_at",
    ];

    public $timestamp = true;

    // public function invoiceDetails(): HasMany
    // {
    //     return $this->hasMany(InvoiceDetail::class, "tax_id");
    // }
}
