<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'insurance';
    protected $fillable = ['type', 'fee', ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'insurance_id');
    }

}
