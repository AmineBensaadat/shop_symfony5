<?php

namespace App\Classes;


use Mailjet\Client;
use Mailjet\Resources;

class Mail

{
    private $api_key = "5b9a6f62487c2833bee40dca93928a64";
    private $api_key_secret = "85c16aec37e89aba1afa30a81703ed8f";

    public function send($to_email, $to_name, $subject, $firstname, $content){
        $mj = new Client($this->api_key, $this->api_key_secret, true, ['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "bensaadat.amine@gmail.com",
                        'Name' => "amine bensaadat"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 3340964,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'firstname' => $firstname,
                        'content' => $content
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}