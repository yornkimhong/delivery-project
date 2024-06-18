<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table  = 'customer';
    protected $fillable = ['name', 'phone', 'receiver_name', 'receiver_phone', 'current_address'];


    public function sentInvoices()
    {
        return $this->hasMany(Invoice::class, 'sender_id');
    }

    public function receivedInvoices()
    {
        return $this->hasMany(Invoice::class, 'receiver_id');
    }
}
