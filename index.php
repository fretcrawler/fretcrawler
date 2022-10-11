<?php require_once('config.php'); ?>
<?php
if (!isset($_SESSION)) {
	session_start();
}

//Load user list
$file = fopen("au.ps","r");
$alloweduser = array();
while (($line = fgets($file)) !== FALSE) {
   array_push($alloweduser, $line);
}
fclose($file);
//echo "<script>alert('".print_r($alloweduser)."');</script>";
//Load user list

// *** Validate request to login to this site.
$loginFormAction = $_SERVER['PHP_SELF'];

$userfound = "No";
$showmsg = "No";
if (isset($_POST['txtuser'])) {
	$usercount = count($alloweduser);
	$myctr = 0;
	
	do{
		$userdetail = explode("|", $alloweduser[$myctr]); 
		$user = $userdetail[0];
		$pass = $userdetail[1];
		
		if($_POST['txtuser'] == trim($user) && $_POST['txtpass'] == trim($pass)){
			$userfound = "Yes";
			break;
		}
		$myctr++;
	} while($myctr<$usercount);
	
	if($userfound=="Yes"){
		$_SESSION["usersess"] = $_POST['txtuser'];
		
		$data = "\r\n".$serverdate."-".$servertime."\r\nLog In success"."\r\n".$_POST['txtuser'];
		file_put_contents("log.ps", $data, FILE_APPEND);//saving fbresponse into text
		
		$LandingPage = 'home.php';
		header("Location: ". $LandingPage );
	} else{
		$showmsg = "Yes";
		
		$data = "\r\n".$serverdate."-".$servertime."\r\nLog In Failed"."\r\n".$_POST['txtuser'];
		file_put_contents("log.ps", $data, FILE_APPEND);//saving fbresponse into text
	}	
}
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html>
<head>
	<title>ErgcpsDbase</title>
   <!--Made with love by Mutiullah Samim -->
   
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<form ACTION="<?php echo $loginFormAction; ?>" name="FormLogIn" method="POST" >
<div class="container">
	<div class="d-flex justify-content-center h-100">
		<div class="card">
			<div class="card-header">
				<h3>ERGCPS Dbase - Sign In</h3>
				<div class="d-flex justify-content-end social_icon">
					<span><i class="fab fa-facebook-square"></i></span>
					<span><i class="fab fa-google-plus-square"></i></span>
					<span><i class="fab fa-twitter-square"></i></span>
				</div>
			</div>
			<div class="card-body">
					<div id="errmsg" style="display: none" align="center">
						<font color="#FF0004">User or password incorrect..</font>
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-user"></i></span>
						</div>
						<input id="txtuser" name="txtuser" type="text" class="form-control" placeholder="username" required>
						
					</div>
					<div class="input-group form-group">
						<div class="input-group-prepend">
							<span class="input-group-text"><i class="fas fa-key"></i></span>
						</div>
						<input id="txtpass" name="txtpass" type="password" class="form-control" placeholder="password" required>
					</div>
					<div class="row align-items-center remember">
						<input type="checkbox">Remember Me
					</div>
					<div class="form-group">
						<input type="submit" value="Login" class="btn float-right login_btn">
					</div>
			</div>
			<div class="card-footer">
				<div class="d-flex justify-content-center links">
					Don't have an account?<a href="#">Sign Up</a>
				</div>
				<div class="d-flex justify-content-center">
					<a href="#">Forgot your password?</a>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
</body>
</html>

<script>
let showmsg = '<?php echo $showmsg;?>';
if(showmsg == "Yes"){
   document.getElementById("errmsg").style.display = "block"
}
</script>