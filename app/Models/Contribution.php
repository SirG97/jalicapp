<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;
    protected $fillable = ['contribution_id','customer_id', 'amount', 'request_type', 'savings_type', 'collected_by',
        'posted_by', 'approved_by', 'collected_on', 'balance', 'gain', 'loan', 'description', 'status'];

    public function user(){
        return $this->belongsTo(User::class, 'posted_by', 'user_id');
    }

    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

}
