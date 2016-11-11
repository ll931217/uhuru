<section id="contact" name="contact" data-section-name="contact">
  <article>
    <header class="page-header">
      <h1>Contact Us</h1>
      <p>
        We like to make new friends, send us a message and we will get right back at you!
      </p>
    </header>
    <article class="contactUs">
      <form class="form-horizontal" method="post" name="contactForm">
        <div class="form-group">
          <label for="inputName" class="col-sm-2 control-label">Name:</label>
          <div class="col-sm-4">
            <input type="text" id="inputName" class="form-control" name="name" placeholder="First Name" />
          </div>
          <label for="inputSName" class="col-sm-2 control-label">Surname:</label>
          <div class="col-sm-4">
            <input type="text" id="inputSName" class="form-control" name="surname" placeholder="Last Name" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail2" class="col-sm-2 control-label">E-mail:</label>
          <div class="col-sm-10">
            <input type="email" id="inputEmail2" class="form-control" name="email" placeholder="example@gmail.com" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputMessage" class="col-sm-2 control-label text-left">Message:</label>
          <div class="col-sm-10">
            <textarea rows="10" id="inputMessage" class="form-control" name="message"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default" name="contactBut">Send</button>
          </div>
        </div>
      </form>
      <?php
        include $root . 'send.php';
        if (isset($_POST['contactBut'])) {
          $sendMail = new SendMail();

          $fromEmail = $_POST['email'];
          $name = $_POST['name'] . ' ' . $_POST['surname'];
          $fromName = $name;
          $toEmail = 'uhuru753@gmail.com';
          $toName = 'Uhuru Economic Network';
          $subject = 'A message from ' . $name;
          $message = '<!DOCTYPE html>
          <html lang="en">

          <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <title>Password hasher</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css">
          </head>

          <body>
            <div class="container">
              <div class="row">
                <div class="col-sm-offset-4 col-sm-6">
                  Message:<br />
                  ' . htmlentities($_POST['message']) . '
                </div>
              </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
          </body>

          </html>';
          $redirect = '<p>Message sent</p>';
          $redirectError = '';
          $sendMail->send($fromEmail, $fromName, $toEmail, $toName, $subject, $message, $redirect, $redirectError);
        }
        if (isset($_REQUEST['mailStatus'])) {
          $texts = split('_', $_REQUEST['mailStatus']);
          $text = join(' ', $texts);
          echo '<p class="error text-danger bg-warning">' . $text . '</p>';
        }
      ?>
    </article>
  </article>
</section>
