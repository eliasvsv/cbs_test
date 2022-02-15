<?php
namespace App\Models;

use CodeIgniter\Model;

class TwilioResponseModel extends Model
{
    protected $table = 'twilio_response';
    protected $primaryKey = 'id';
    protected $allowedFields = ['message_id', 'date','twilio_code'];
}
?>