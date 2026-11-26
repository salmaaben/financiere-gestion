<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueStatus extends Model
{
    use HasFactory;

    protected $table = 'revenue_statuses';

    protected $fillable = [
        'name',
    ];
}