<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'name', 'title', 'marital_status', 'dob', 'phone', 'email', 'address',
        'occupation', 'sex', 'image', 'saving_period', 'amount', 'account_number', 'account_name',
        'bank', 'purpose', 'kin_name', 'kin_address', 'kin_phone', 'kin_relationship', 'kin_image',
        'branch', 'unit_manager', 'unit_manager_phone', 'office', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
