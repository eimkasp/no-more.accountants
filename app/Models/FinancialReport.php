<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'report_type',
        'start_date',
        'end_date',
        'total_income',
        'total_expenses',
        'profit_or_loss',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_income' => 'decimal:2',
        'total_expenses' => 'decimal:2',
        'profit_or_loss' => 'decimal:2',
    ];

    /**
     * Get the company that owns the financial report.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
