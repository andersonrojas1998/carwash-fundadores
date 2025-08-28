<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class EmployeePayment extends Model {
    protected $table = 'employee_payments';
    protected $fillable = ['user_id', 'total_servicios', 'total_prestamos', 'total_balance_anterior', 'total_pagado', 'fecha_pago'];
}