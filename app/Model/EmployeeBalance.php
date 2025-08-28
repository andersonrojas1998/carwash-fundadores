<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class EmployeeBalance extends Model {
    protected $table = 'employee_balances';
    protected $fillable = ['user_id', 'saldo', 'updated_at'];
}