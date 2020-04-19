<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Contact form</title>
      <link rel="icon" type="image/png" href="../../img/logoC.png" sizes="32x32">
<link rel='stylesheet' href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>

  <body>
<div class="container-fluid bg-secondary">


  <form class="form-signin" role="form" action="send_via_gmail.php" method="post">
      <h3 class =""style="text-align: center;">Contact Us</h3>


          <div class="row">
            <div class="col">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white"><i class="fa fa-envelope"></i></span>
                  </div>
                  <input id="mail" name="email" type="email" placeholder="Email" class="form-control border-left-0" required>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text bg-white"><i class="fa fa-user"></i>&nbsp</span>
                  </div>
                  <input name="name" id="name" type="text" placeholder="Name" class="form-control border-left-0 border" required>
                </div>
              </div>
          </div>
        </div>
<div class="form-group">
      <input id="subject" name="subject" type="text" placeholder="Subject" class="form-control">
      </div>
          <div class="form-group">
              <textarea class="form-control" id="message" name="message" rows="5" placeholder="Enter message" required></textarea>
          </div>

          <button type="submit" class="btn btn-primary float-right">
            <i class="fa fa-paper-plane"></i>
            Send
          </button>



  </form><a href="../index/index.php ">
  <button  style="float: left;" class="btn btn-primary float-left">
    <i class="fa fa-home"></i>
    Back to home
  </button>
  </a>
  </div>
  </body>

</html>
