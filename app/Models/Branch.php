<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'branch';
    protected $fillable = ['name', 'phone', 'alt_phone', 'location'];

    public function senderInvoices()
    {
        return $this->hasMany(Invoice::class, 'sender_branch_id');
    }

    public function receiverInvoices()
    {
        return $this->hasMany(Invoice::class, 'receiver_branch_id');
    }

    public function branchConfirms()
    {
        return $this->hasMany(BranchConfirm::class);
    }
}
