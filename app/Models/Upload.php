<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{

    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'invoice_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    /**
     * Get the company that owns the upload.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the invoice associated with the upload.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
