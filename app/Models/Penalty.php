<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'penalty';
    protected $fillable = ['name', 'description',];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'penalty_id');
    }
}
