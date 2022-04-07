<?php
 if(isset($_GET['msg'])){

      if($_GET['msg']!=1){

        echo "This site can’t be reached";die();

      }}

?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a class="h1"><b>Shop Admin Panel</b></a>
    </div>
    <div class="card-body">
      <?php
       if(isset($_GET['msg'])){

      if($_GET['msg']==1){
      echo '<p class="login-box-msg" style="color:green"><b>Your SuccessFully Logout<b></p>';

       }
      }
      ?>

    
   <form action="" method="POST" id="LoginForm">
      <p class="login-box-msg" id="msg" style="display: none;color:red">Sign in to View Shop.</p>
      <label>Username</label>
        <div class="input-group mb-3">

          <input type="text" class="form-control" id="username" name="username" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <label>password</label>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="userpas" name="userpass" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" id="">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
               </form>
        </div>
    

     <!--  <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="#">I forgot my password</a>
      </p>
  <!--     <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
<script type="text/javascript">
$(document).ready(function (e) {
$("#LoginForm").on('submit',(function(e) {
                e.preventDefault();

        var username= $("#username").val() ;
        var userpass= $("#userpas").val() ;
        var info= "true" ;
         // alert(username);
         // alert(userpass);
        // alert(info);
        if(username==="" || userpass==="")
        {

         swal('WARNING','Please Enter UserName & Password','error');
         // alert("Please Enter UserName & Password");
        }else{

        $.ajax({
      url: 'includes/login.php',
      type: "POST",
      data:new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
    success: function( data ){
      
        //alert(data);
          $("#username").val('');
          $("#userpas").val('');
          $('#msg').html(data);
          
          //alert('Incorrent UserName and Password');
          //swal('WARNING','Incorrent UserName and Password','error');
          $("#msg").show() ;
        }
         
       
      });

      }
}));

});
</script>