<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchConfirm extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'branch_confirm';
    protected $fillable = ['invoice_id', 'branch_id', 'confirm_status'];


    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class); 
    }
}
