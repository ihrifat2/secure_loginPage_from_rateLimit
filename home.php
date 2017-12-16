<?php
session_start();

if (!isset($_SESSION['user_login'])) {
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Imran">
    <title>Home</title>
    <link href="https://v4-alpha.getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="http://fontawesome.io/assets/font-awesome/css/font-awesome.css">
    <link href="css/cover.css" rel="stylesheet">
</head>
<body>
    <div class="site-wrapper">
        <div class="site-wrapper-inner">
            <div class="cover-container">
                <div class="masthead clearfix">
                    <div class="inner">
                        <h3 class="masthead-brand">Logo</h3>
                        <nav class="nav nav-masthead">
                            <a class="nav-link active" href="#nav1">nav1</a>
                            <a class="nav-link" href="#nav2">nav2</a>
                            <a class="nav-link" href="#nav3">nav3</a>
                            <a class="nav-link" href="logout.php">logout</a>
                        </nav>
                    </div>
                </div>
                <div class="inner cover">
                    <h1 class="cover-heading">Welcome <?php echo ucfirst($_SESSION['user_login']); ?></h1>
                </div>
                <div class="mastfoot">
                    <div class="inner">
                        <p><a href="https://github.com/ihrifat2"><i class="fa fa-github" aria-hidden="true" style="font-size: 25px;"></i> Github</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
