<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Modelling 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20120617

-->

<html xmlns="http://www.w3.org/1999/xhtml">



<head>
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>rasi</title>



<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jQuery Validation Plugin 1.9.0.js"></script>
<link href="styles/style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="styles/popup-style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.leanModal.min.js"></script>






<script>
$(function() {
$('a[rel*=leanModal]').leanModal({ top : 200, closeButton: ".modal_close" });		
});
</script>


<script type="text/javascript">
	
$(document).ready(function(){
		$("#loginform").validate({
			debug: false,
			rules: {
				username: "required",
                                password: "required"
			},
			messages: {
				username: "Please let us know who you are.",
                                password: "Password must be provided"

			},
			submitHandler: function(form) {				
				$.post('validateLogin.php', $("#loginform").serialize(), function(data) {
				window.location.href =  data
				
				});
			}
		});
                
            
	});



$(document).ready(function(){
		$("#signupform").validate({
			debug: false,
			rules: {
				username: "required",
                                password: "required",
				email	: "required"
			},
			messages: {
				username: "Please let us know who you are.",
                                password: "Password must be provided",
				email	: "Please let us know your mail id"

			},
			submitHandler: function(form) {
				$.post('register.php', $("#signupform").serialize(), function(data) {
				window.location.href =  "words.php";				});
			}
		});
                
            
	});

</script>





</head>
<body>

	<div id="login">
		<div id="login-ct">
			<div id="login-header">
				<h2 name="cs">Login</h2>
				<a class="modal_close" href="#"></a>
			</div>
		
			<form name="loginform" id="loginform" action="" method="post">  

			  <div class="txt-fld">
			    <label for="">Username</label>
			    <input  class="good_input" id="username" name="username" type="text" />

			  </div>
			  <div class="txt-fld">
			    <label for="">Password</label>

			    <input name="password"  id="password"type="password" />

			  </div>
			  <div class="btn-fld">
			  	<button type="submit"  name="submit">Login&raquo;</button>
		          </div>
			 </form>
		</div>
	</div>

	<div id="signup">
		<div id="signup-ct">
			<div id="signup-header">
				<h2>Sign Up</h2>
				<a class="modal_close" href="#"></a>
			</div>
		
			<form name="signupform" id="signupform" action="" method="post">  

			  <div class="txt-fld">
			    <label for="">Username</label>
			    <input id="" class="username" name="username" type="text" />

			  </div>
			  <div class="txt-fld">
			    <label for="">Email address</label>
			    <input id="" name="email" type="text" />
			  </div>
			  <div class="txt-fld">
			    <label for="">Password</label>
			    <input id="" name="password" type="password" />

			  </div>
			  <div class="btn-fld">
			  	<button type="submit"  name="submit">Login&raquo;</button>
		          </div>

			 </form>
		</div>
	</div>


<div id="wrapper">
	<div id="wrapper2">

		<div id="page">
		<!-- end #header -->


<div class="menulinks">
			<strong>Lets start ?</strong>
			<a id="go"  rel="leanModal"  href="#login">Join</a> | <a id="go" rel="leanModal"  href="#signup">Sign Up</a>
		</div>

		<div id="banner-wrapper">
			
			<img src="images/banner-image.jpg" width="820px" height="380px" />		
		</div>
			<div id="content">
				<div class="post">
					<h2 class="title"><a href="#">Welcome to rasi </a></h2>
					<p class="meta"><span class="date">feb 27, 2013</span><span class="posted">Posted by <a href="http://fsmk.org/">FSMK</a></span></p>
					<div style="clear: both;">&nbsp;</div>
					<div class="entry">
						<p>Sample text<strong>Sample text </strong>, Sample text, Sample text Sample text Sample textSample text Sample textSample text. Sample textSample text Sample text Sample text Sample text Sample textSample text text Sample textSample text. Sample textSample text Sample text Sample text Sample text Sample textSample text  text Sample textSample text. Sample textSample text Sample text Sample text Sample text Sample textSample text  text Sample textSample text. Sample textSample text Sample text Sample text Sample text Sample textSample text </p>
						<p>Sample text Sample textSample text  text Sample textSample text. Sample textSample text Sample text Sample text Sample text Sample textSample text Sample text Sample textSample text  text Sample textSample text. Sample textSample text Sample text Sample text Sample text Sample textSample text Sample text Sample textSample text  text Sample textSample text. Sample textSample text Sample text Sample text Sample text Sample textSample text  <br />
						</p>
					</div>
				</div>
			</div>
			<!-- end #content -->
			<div style="clear: both;">&nbsp;</div>
		</div>
		<!-- end #page --> 
	</div>
</div>
<!-- end #footer -->
</body>
<?php
echo $_GET[err_val];
if($_GET[err_val]==1)
{
echo "<script>alert('The username and password not exist Sign Up for new user');</script>";
}/*
else if($_GET[err_val]==2)
{
echo "<script>alert('The username already exist try with different username');</script>";
}*/

?>
</html>
