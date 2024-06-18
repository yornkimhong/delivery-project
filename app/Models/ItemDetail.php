<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemDetail extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'item_detail';
    protected $primaryKey = 'id'; // Assuming 'id' is the primary key in item_detail table
    protected $fillable = [
        'description',
        'quantity',
    ];

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'item_detail_id'); // Has one Invoice associated via item_detail_id
    }
}
