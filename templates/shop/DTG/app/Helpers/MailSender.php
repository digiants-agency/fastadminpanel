<?php  

namespace App\Helpers;

class MailSender {

    private $from;

    public function __construct($from = 'info@dtg.digiants.agency') {

        $this->from = $from;
    }

    public function send($to, $subject, $message) {

      $headers = 'From: '. $this->from . "\r\n" .
          'Reply-To: '. $this->from . "\r\n" .
          'X-Mailer: PHP/' . phpversion();

      mail($to, $subject, $message, $headers);
      
    }
}