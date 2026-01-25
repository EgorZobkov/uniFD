<?php

/**
 * UniSite CMS
 * @link    https://unisite.org
 * We are for a beautiful and fast code! Made with love!❤️
 */

namespace App\Systems;

use App\Systems\PHPMailer\PHPMailer;
use App\Systems\PHPMailer\SMTP;
use App\Systems\PHPMailer\Exception;

class Mailer
{

    public $mailer_service = null;
    public $mailer_from_email = null;
    public $mailer_from_name = null;
    public $mailer_smtp_host = null;
    public $mailer_smtp_username = null;
    public $mailer_smtp_password = null;
    public $mailer_smtp_port = null;
    public $mailer_smtp_secure = null;
    public $mailer_service_api_key = null;
    public $debug = 0;

    public function __construct(){
        global $app;

        $this->mailer_service = $app->settings->mailer_service;
        $this->mailer_from_email = $app->settings->mailer_from_email;
        $this->mailer_from_name = $app->settings->mailer_from_name;
        $this->mailer_smtp_host = $app->settings->mailer_smtp_host;
        $this->mailer_smtp_username = $app->settings->mailer_smtp_username;
        $this->mailer_smtp_password = $app->settings->mailer_smtp_password;
        $this->mailer_smtp_port = $app->settings->mailer_smtp_port;
        $this->mailer_smtp_secure = $app->settings->mailer_smtp_secure;
        $this->mailer_service_api_key = decrypt($app->settings->mailer_service_api_key);
    }

    public function body($body=[]){
        $this->body = $body;
        return $this;
    }

    public function to($to=null){
        $this->to = $to;
        return $this;
    }

    public function send(){
        global $app;

        $mail = new PHPMailer(true);

        if(!$this->mailer_service){

            try {

                ob_start();
                
                $mail->SMTPDebug = 1;
                $mail->setFrom($this->mailer_from_email, $this->mailer_from_name);
                $mail->addReplyTo($this->mailer_from_email, $this->mailer_from_name);
                $mail->Timeout = 3;
                $mail->CharSet = "utf-8"; 

                if(is_array($this->to)){
                    foreach ($this->to as $email) {
                        $mail->addAddress($email);
                    }
                }else{
                    $mail->addAddress($this->to);
                }

                if(isset($this->body['attachments'])){
                    if(is_array($this->body['attachments'])){
                        foreach ($this->body['attachments'] as $file) {
                            $mail->addAttachment($file);
                        }
                    }
                }

                $mail->isHTML(true);
                if(isset($this->body['subject'])){
                    $mail->Subject = $this->body['subject'];
                }
                $mail->Body = $this->body['body'];
                if(isset($this->body['altText'])){
                    $mail->AltBody = $this->body['altText'];
                }

                $mail->send();

                $result = ob_get_clean();

                return $result;

            } catch (Exception $e) {
                logger("Mailer: {$mail->ErrorInfo}");
                return $mail->ErrorInfo;
            }

        }elseif($this->mailer_service == "smtp"){

            try {

                ob_start();

                $mail->isSMTP();
                $mail->SMTPDebug = 1;
                $mail->Host       = $this->mailer_smtp_host;                    
                $mail->SMTPAuth   = true;
                $mail->Username   = $this->mailer_smtp_username;                    
                $mail->Password   = $this->mailer_smtp_password;                               
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = $this->mailer_smtp_port;     
                $mail->Timeout = 3;   
                $mail->CharSet = "utf-8";        

                if($this->mailer_smtp_secure == "TLS"){
                    $mail->SMTPOptions = [
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        ]
                    ];
                }

                $mail->setFrom($this->mailer_from_email, $this->mailer_from_name);
                $mail->addReplyTo($this->mailer_from_email, $this->mailer_from_name);

                if(is_array($this->to)){
                    foreach ($this->to as $email) {
                        $mail->addAddress($email);
                    }
                }else{
                    $mail->addAddress($this->to);
                }

                if(isset($this->body['attachments'])){
                    if(is_array($this->body['attachments'])){
                        foreach ($this->body['attachments'] as $file) {
                            $mail->addAttachment($file);
                        }
                    }
                }

                $mail->isHTML(true);

                if(isset($this->body['subject'])){
                    $mail->Subject = $this->body['subject'];
                }

                $mail->Body = $this->body['body'];
                
                if(isset($this->body['altText'])){
                    $mail->AltBody = $this->body['altText'];
                }

                $mail->send();

                $result = ob_get_clean();

                return $result;

            } catch (Exception $e) {
                logger("Mailer: {$mail->ErrorInfo}");
                return $mail->ErrorInfo;
            }

        }else{

            try {

                $vendor = $app->addons->smtp(intval($this->mailer_service));

                return $vendor->sendByApi(["api_key"=>$this->mailer_service_api_key, "from_name"=>$this->mailer_from_name, "from_email"=>$this->mailer_from_email, "body"=>$this->body['body'], "to"=>$this->to, "subject"=>$this->body['subject']]);

            } catch (Exception $e) {
                logger("Smtp: {$e->getMessage()}");
                return $e->getMessage();
            }

        }

    }

}