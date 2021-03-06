<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Log in</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<!-- Bootstrap 3.3.2 -->
		<link href="assets/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="assets/admin/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
		<!-- iCheck -->
		<link href="assets/admin/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		<style>
			.modal-dialog-custom {
				background: rgba(232, 227, 227, 0.35) none repeat scroll 0 0;
				border-radius: 5px;
				margin: 50px auto;
				padding: 30px;
				width: 100%;
			}
		</style>
  	</head>
  	<body class="login-page" style="background-image: url('{{asset('assets/imagenes/fondo.png')}}'); background-size: cover; height: initial">
    	<div class="login-box">
      		<div class="login-box-body modal-dialog-custom">
			  	<div class="login-logo">
					<img src="{{asset('assets/imagenes/logos/logo.jpg')}}" width="100px" style="border-radius: 10px"><br/>
					<b style="color: white">Inicio de Sesión</b>
				</div><!-- /.login-logo -->
				{!! Form::open(['route' => 'login', 'method' => 'POST', 'role' => 'form', 'class'=>'validate-form']) !!}
	        		@if(Session::has('login-error'))
		            	<div class="alert alert-danger alert-dismissable">
		              		<h4>{{Session::get('login-error')}}</h4>
		           		</div>
		          	@endif
		          	@if(Session::has('error'))
		            	<div class="alert alert-danger alert-dismissable">
		              		<h4>{{Session::get('error')}}</h4>
		           		</div>
		          	@endif
	          		<div class="form-group has-feedback">
	        			<input type="text" name="username" class="form-control" placeholder="Username"/>
	            		<span class="glyphicon glyphicon-user form-control-feedback"></span>
          			</div>
		          	<div class="form-group has-feedback">
		            	<input type="password" name="password" class="form-control" placeholder="Password"/>
		            	<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		          	</div>
		          	<div class="row">
		            	<div class="col-xs-12">
		              		<button type="submit" class="btn btn-primary btn-block btn-flat">Iniciar Sesión</button>
		            	</div><!-- /.col -->
		          	</div>
    			{!! Form::close() !!}
      		</div><!-- /.login-box-body -->
		</div><!-- /.login-box -->

	    <!-- jQuery 2.1.3 -->
	    <script src="assets/admin/plugins/jQuery/jQuery-2.2.3.min.js"></script>
	    <!-- Bootstrap 3.3.2 JS -->
	    <script src="assets/admin/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	    <!-- iCheck -->
	    <script src="assets/admin/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	    <script>
      		$(function () {
		        $('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' // optional
		        });
      		});
    	</script>
  	</body>
</html>