<?php
$username = "";
$err = "";
include('./classes/baza.php');
include('./classes/Login.php');

if (Login::isLoggedIn()) {
        //$err = 'Logged In';
        $iduser = Login::isLoggedIn();
        $username = baza::query('SELECT username FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$iduser))[0]['username'];
} else {
        $err = 'Not logged in';
        header('location: index_logout.php');
}
?>
<html>
<head>
	<title>PetVet</title>
	<link rel = "stylesheet" type="text/css" href = "css/stil_login.css"> 
	<style type="text/css">
		
		#div1 {
			width: 400px;
			height: 550px;
			margin-left: 50px;
			background-color: rgba(3, 117, 180, 0.3);
			float: left;
			
		}
		#div3 {
			width: 400px;
			height: 550px;
			margin-left: -70px;
			background-color: rgba(16, 194, 53, 0.3);
			float: left;
			
		}
		#div2 {
			width: 400px;
			height: 550px;
			margin-left: -90px;
			margin-right: 50px;
			background-color: rgba(255, 206, 0, 0.3);
			float: right;
		}
		
		
	</style>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body style="background-image: url('images/bg-homepage-01.png');">
	<nav class="navbar navbar-dark bg-dark">
        <span class="navbar-text navbar-dark bg-dark" >
		    <font color="#ecf0f1">	Bun venit <?php echo $username;?>!<?php echo $err;?>
			</font>
	    </span>
     </nav>
	<br> 
	<br>
	  <center>
	
		<div id = "div1">
			<br>
			<img src="images/caine-01.svg" style="width:50%" >
			<br>
			<br>
			<br>
			<br>
			<form action="pacienti.php" method="post">
				<input type="submit" name="pacienti" value="Pacienti" class="button">
			</form>
		</div>
		<div id = "div3">
			<br>
			<img src="images/pastila-01.svg" style="width:50%" >
			<br>
			<br>
			<br>
			<br>
			<form action="inventar.php" method="post">
				<input type="submit" name="inventar" value="Inventar" class="button">
			</form>
		</div>
		<div id = "div2">
			<br>
			<img src="images/doctor-01.svg" style="width:50%" >
			<br>
			<br>
			<br>
			<br>
			<form action="my_account.php" method="post">
				<input type="submit" name="cont" value="Contul Tau" class="button">
			</form>
		</div>
		</center>
	
	
	
</body>
</html>