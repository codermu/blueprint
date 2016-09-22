
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Festiware </title>

    <!-- Bootstrap -->
    <link href="{{ asset("assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset("assets/gentelella/vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="https://colorlib.com/polygon/gentelella/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset("assets/gentelella/build/css/custom.min.css") }}" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form method="post" action="{{url('/process-reset-pass')}}" class="form-forget">
              {{csrf_field()}}
              	<div class="msg-text"><br /><br />
					@if(Session::has('message'))
						<span> {{ Session::get('message')}} </span>
					@endif
					@if($errors->has())
						<span>{!! $errors->first('email') !!}</span>
					@endif
				</div>
              <h1>Please Enter Your Email</h1>
              <div>
              	<input type="text" name="email" id="email" placeholder="Email" class="form-control" > <br> <br>
				<input type="submit" value="Forget password" class="btn btn-default submitr"/>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1> Indosystem CMS </h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
	  </div>
    </div>
  </body>
</html>