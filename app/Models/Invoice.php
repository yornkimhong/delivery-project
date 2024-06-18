<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'invoice';
    protected $fillable = [
        'payment_method', 'insurance_id', 'penalty_id', 'item_detail_id', 'sender_branch_id',
        'receiver_branch_id', 'sender_id', 'receiver_id', 
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method');
    }
    public function insurance()
    {
        return $this->belongsTo(Insurance::class, 'insurance_id');
    }
    public function penalty()
    {
        return $this->belongsTo(Penalty::class, 'penalty_id');
    }
    public function itemDetail()
    {
        return $this->belongsTo(ItemDetail::class, 'item_detail_id'); // Belongs to an ItemDetail
    }
    // for branch table
    public function senderBranch()
    {
        return $this->belongsTo(Branch::class, 'sender_branch_id');
    }

    public function receiverBranch()
    {
        return $this->belongsTo(Branch::class, 'receiver_branch_id');
    }

    public function branchConfirms()
    {
        return $this->hasMany(BranchConfirm::class);
    }
    // for table customer
    public function sender()
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Customer::class, 'receiver_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($invoice) {
            $invoice->itemDetail()->delete();
            $invoice->sender()->delete();
            $invoice->receiver()->delete();
        });
    }

}
