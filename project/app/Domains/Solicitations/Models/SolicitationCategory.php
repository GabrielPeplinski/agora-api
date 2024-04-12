<?php

namespace App\Domains\Solicitations\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitationCategory extends Model
{
    protected $table = 'solicitation_categories';

    protected $fillable = [
        'name',
        'description',
    ];
}
