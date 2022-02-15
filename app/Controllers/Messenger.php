<?php

namespace App\Controllers;
use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;
use CodeIgniter\API\ResponseTrait;
use App\Models\MessageModel;
use App\Models\TwilioResponseModel;
use PhpParser\Node\Stmt\TryCatch;

class Messenger extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect(); 
    }
    public function index()
    {
        return view('messenger');
    }

    public function send()
    {
        $tw_code="sent";
        $number= $this->request->getVar('number');
        $text= $this->request->getVar('text');
        $account_sid = TWILIO_SID;
        $auth_token = TWILIO_TOKEN;
        $twilio_number = TWILIO_NUMBER;
        $client = new Client($account_sid, $auth_token);
        try {
            $sms    =    $client->messages->create(
                "+".$number,
                 array(
                     'from' => $twilio_number,
                     'body' => $text
                 )
             );
        } catch (RestException $e) {
            $tw_code="error";
        
        }
       
        $date = date("Y-m-d H:i:s"); 
        $data=array(
            "date"   =>$date,
            "message" =>$text,
            "to"     =>$number
        );      
       $model = new MessageModel();
       $model->insert($data);
       $message_id= $model->getInsertID();
       $twilioResponse = new TwilioResponseModel();
       $res = array(
           "message_id"=>$message_id,
           "date"=>$date,
           "twilio_code"=>$tw_code
       );
       $twilioResponse->insert($res);
      echo json_encode($data);
    }

    public function getLastest()
    {
        $builder = $this->db->table('messages as m');
        $builder->select('m.id,m.date,m.to,m.message,tr.twilio_code as statusCode');
        $builder->join('twilio_response tr ', 'm.id = tr.message_id');
        $data["data"] = $builder->get()->getResult();
        return json_encode($data);
    }
}