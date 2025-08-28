<?php

namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class EmployeeBalanceMovement extends Model {
    protected $table = 'employee_balance_movements';
    protected $fillable = ['user_id', 'saldo_anterior', 'movimiento', 'saldo_nuevo', 'motivo', 'created_at'];
}