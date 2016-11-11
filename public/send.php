<?php
  $root = $_SERVER['DOCUMENT_ROOT'] . "/uhuru/public/";
  $root2 = "/uhuru/public/";
  class SendMail {

    public function send($fromEmail, $fromName, $toEmail, $toName, $subject, $message, $redirect, $redirectError) {
      require $root . 'phpmailer/PHPMailerAutoload.php';

      $mail = new PHPMailer;

      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'uhuru753@gmail.com';
      $mail->Password = 'v>4;@d%(486<fBM~';
      $mail->SMTPSecure = 'ssl';
      $mail->Port = 465;
      $mail->setFrom($fromEmail, $fromName);
      $mail->addAddress($toEmail, $toName);
      $mail->WordWrap = 50;
      $mail->isHTML(true);

      $mail->Subject = $subject;
      $mail->Body    = $message;

      if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        exit;
      }

      echo $redirect;
    }
  }
?>
