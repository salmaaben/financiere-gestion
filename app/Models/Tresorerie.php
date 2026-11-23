<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tresorerie extends Model
{
    protected $table = 'tresoreries';

    protected $fillable = [
        'caisse',
        'banque'
    ];
}