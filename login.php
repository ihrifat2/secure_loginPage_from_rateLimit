<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="css/style.css">
	<style type="text/css">
		.hide{
			display: none;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row" id="loginForm">
			<div class="panel-heading">
               <div class="panel-title text-center">
               		<a class="loginhead" href="login.php"><h1 class="title">Login</h1></a>
               	</div>
            </div> 

			<div class="main-login main-center">
				<form class="form-horizontal" method="post" action="#">
					<div class="form-group">
						<label for="username" class="cols-sm-2 control-label">Username</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user-circle fa-spin" aria-hidden="true"></i></span>
								<input type="text" class="form-control" name="uname" maxlength="35" id="username" placeholder="Enter your Username"/>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="cols-sm-2 control-label">Password</label>
						<div class="cols-sm-10">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-lock fa-spin" aria-hidden="true"></i></span>
								<input type="password" class="form-control" name="passwd" maxlength="35" id="password" placeholder="Enter your Password"/>
							</div>
						</div>
					</div>
					<div class="form-group ">
						<button type="submit" name="login_btn" class="btn btn-primary btn-lg btn-block login-button"><i class="fa fa-user-o" aria-hidden="true"></i> Login</button>
					</div>
					<p id="error"></p>
				</form>
			</div>
		</div>
	</div>
	<script>
	// Set the time 5 minutes in countDownDate variable while blocking ip address
	var countDownDate = new Date().getTime()+301000;
	//var countDownDate = new Date().getTime()+10000;
	// Update the count down every 1 second
	var x = setInterval(function() {
	    // Get todays time
	    var now = new Date().getTime();
	    // Find the distance between now an the count down date
	    var distance = countDownDate - now;
	    // Time calculations for minutes and seconds
	    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
	    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	    // Output the result in an element with id="demo"
	    document.getElementById("demo").innerHTML =  minutes + "m " + seconds + "s ";
	    // If the count down is over, write some text 
	    if (distance < 0) {
	        clearInterval(x);
	        document.getElementById("demo").innerHTML = "<font color='red'>EXPIRED</font>";
	        location.reload();
	        window.location.assign("logout.php")
	    }
	}, 1000);
</script>
<?php

require 'config.php';
error_reporting(0);
session_start();

if ($_SESSION['badIP']) {
	echo "<center><h1>Your IP address is blocked for 5 minutes</h1>";
	echo '<p id="demo"></p>';
	echo "<script>document.getElementById('loginForm').setAttribute('class', 'row hide')</script>";
	// echo "<script>document.documentElement.innerHTML = 'Your IP address is blocked.';</script>";
	header("HTTP/1.1 401 Unauthorized");
	die();
}

if (!$_COOKIE['failed']) {
	unset($_SESSION['badIP']);
}

if (isset($_POST['login_btn'])) {
	$username = $_POST['uname'];
	$password = $_POST['passwd'];
	if (empty($username) || empty($password)) {
		echo "<script>document.getElementById('error').innerHTML = 'All Field are required.';</script>";
	}else{
		if ($_SESSION['badIP']) {
			echo "<script>document.documentElement.innerHTML = 'Your IP address is blocked.';</script>";
			header("HTTP/1.1 401 Unauthorized");
		}else{
			$conn = mysqli_connect($host, $user, $pass, $db) or die ("Error while connecting to database");
			$query = "SELECT * FROM usr_info WHERE username = '$username' AND password = '$password'";
			$result= mysqli_query($conn, $query);
			$rows = mysqli_fetch_assoc($result);
			if ($rows) {
				$_SESSION['user_login'] = $rows['username'];
				unset($_SESSION['failattempts']);
				unset($_SESSION['badIP']);
				header('Location: home.php');
			}else{				
				echo "<script>document.getElementById('error').innerHTML = 'Username or Password not match';</script>";
				$ip = get_ip_address();

				if ($_SESSION['failattempts']) {
					$failattempt = $_SESSION['failattempts'];
					$failattempt++;
					$_SESSION['failattempts'] = $failattempt;

					if ($_SESSION['failattempts'] >= 6) {
						echo "<script>document.getElementById('error').innerHTML = 'Too many request.';</script>";
						header("HTTP/1.1 429 Too Many Requests");
					}

					/* Rate limiting user request */

					if ($_SESSION['failattempts'] >= 16) {
						setcookie("failed", $_SESSION['failattempts'] , time()+10);
						$_SESSION['badIP'] = $ip;
						header("HTTP/1.1 401 Unauthorized");
					}
				}else{
					$failattempt = 1;
					$_SESSION['failattempts'] = $failattempt;
				}
			}
			mysqli_close($conn);
		}
	}	
}

function get_ip_address() {

    // check for shared internet/ISP IP
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    }

    // check for IPs passing through proxies
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // check if multiple ips exist in var
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
            $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            foreach ($iplist as $ip) {
                if (validate_ip($ip))
                    return $ip;
            }
        } else {
            if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
        return $_SERVER['HTTP_X_FORWARDED'];
    if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
        return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
        return $_SERVER['HTTP_FORWARDED_FOR'];
    if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
        return $_SERVER['HTTP_FORWARDED'];

    // return unreliable ip since all else failed
    return $_SERVER['REMOTE_ADDR'];
}

function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;

    // generate ipv4 network address
    $ip = ip2long($ip);

    // if the ip is set and not equivalent to 255.255.255.255
    if ($ip !== false && $ip !== -1) {
        // make sure to get unsigned long representation of ip
        // due to discrepancies between 32 and 64 bit OSes and
        // signed numbers (ints default to signed in PHP)
        $ip = sprintf('%u', $ip);
        // do private network range checking
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}
?>
</body>
</html>