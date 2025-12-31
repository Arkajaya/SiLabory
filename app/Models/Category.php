<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'code',
        'stock',
        'condition',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loanDetails()
    {
        return $this->hasMany(LoanDetail::class);
    }
}
