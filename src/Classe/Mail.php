<?php 

namespace App\Classe;
use Mailjet\Client;
use \Mailjet\Resources;

class Mail
{
   public function send($mail, $name, $subject)
   {
      $mj = new Client($_SERVER['APIKEY_PUBLIC'], $_SERVER['APIKEY_PRIVATE'],true,['version' => 'v3.1']);

      $body = [
          'Messages' => [
              [
                  'From' => [
                      'Email' => "limacedric@hotmail.fr",
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