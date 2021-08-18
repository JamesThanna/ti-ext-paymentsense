<?php
namespace MiOrder\PaymentSense\Models;
use ApplicationException;
use Exception;
use Igniter\Flame\Database\Traits\Validation;
use Illuminate\Support\Facades\Log;
use Model;
use Request;

class PsPayment extends Model
{
    

    /**
     * @var string The database table name
     */
    protected $table = 'payment_sense';
  
    protected $fillable = ['order_number', 'token', 'auth', 'auth_responce','completed', 'completed_responce'];
}