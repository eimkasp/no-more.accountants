<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'client_name',
        'client_tax_id',
        'amount',
        'status',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // /**
    //  * Get the company that owns the invoice.
    //  */
    // public function company()
    // {
    //     return $this->belongsTo(Company::class);
    // }

    // /**
    //  * Get the payments related to this invoice.
    //  */
    // public function payments()
    // {
    //     return $this->hasMany(Payment::class);
    // }
}
