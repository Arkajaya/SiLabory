<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class LoanDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'loan_id',
        'item_id',
        'quantity',
        'condition',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
