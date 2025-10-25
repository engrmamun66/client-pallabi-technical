<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerLogo extends Model
{
    use HasFactory;
    protected $fillable = [
        'link',
        'image',
        'created_at',
        'updated_at',
    ];
}
