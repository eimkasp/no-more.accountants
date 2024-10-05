<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'tax_name',
        'tax_rate',
    ];

    /**
     * Get the company that owns the tax rate.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
