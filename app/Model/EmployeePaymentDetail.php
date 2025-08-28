<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class EmployeePaymentDetail extends Model {
    protected $table = 'employee_payment_details';
    protected $fillable = ['payment_id', 'tipo', 'referencia_id', 'valor'];
}