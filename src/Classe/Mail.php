<?php 

namespace App\Classe;
use Mailjet\Client;
use \Mailjet\Resources;

class Mail
{
   private $api_key = "d2bead7f4b8962cad7a7ad3b21cfb79f";
   private $api_secret = "1da6c85b74171822fec7a21dfb7511c5";

   
   public function send($mail, $name, $subject)
   {
      $mj = new Client($this->api_key, $this->api_secret,true,['version' => 'v3.1']);
      $body = [
          'Messages' => [
              [
                  'From' => [
                      'Email' => "pilot@mailjet.com",
                      'Name' => "Test"
                  ],
                  'To' => [
                      [
                          'Email' => $mail,
                          'Name' => $name
                      ]
                  ],
                  'TemplateID' => 2288102,
                  'TemplateLanguage' => true,
                  'Subject' => $subject,
              ]
          ]
      ];
      $response = $mj->post(Resources::$Email, ['body' => $body]);
      $response->success() && dd($response->getData());
   }


}