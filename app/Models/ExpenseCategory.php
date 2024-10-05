<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'category_name',
        'description',
    ];

    /**
     * Get the company that owns the expense category.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the transactions associated with the expense category.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'category', 'category_name');
    }
}
