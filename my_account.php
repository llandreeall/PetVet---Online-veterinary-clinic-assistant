<?php
$username = "";
$err = "";
include('./classes/baza.php');
include('./classes/Login.php');

if (Login::isLoggedIn()) {
        //$err = 'Logged In';
        $iduser = Login::isLoggedIn();
        $username = baza::query('SELECT username FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$iduser))[0]['username'];
        $nume = baza::query('SELECT nume FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$iduser))[0]['nume'];
        $prenume = baza::query('SELECT prenume FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$iduser))[0]['prenume'];
        $cnp = baza::query('SELECT cnp FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$iduser))[0]['cnp'];
        $specializare = baza::query('SELECT specializare FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$iduser))[0]['specializare'];
        $parola = baza::query('SELECT parola FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$iduser))[0]['parola'];
} else {
        $err = 'Not logged in';
        header('location: index_logout.php');
}


if (isset($_POST['update'])) {
        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $cnp = $_POST['cnp'];
        $username = $_POST['username'];
        $parola = $_POST['parola'];
        $specializare = $_POST['specializare'];
    
        if($parola) {
        baza::query('UPDATE petvet.medici SET parola=:newpassword WHERE id=:iduser', array(':newpassword'=>password_hash($parola, PASSWORD_BCRYPT), ':iduser'=>$iduser));  }
    
        baza::query('UPDATE petvet.medici SET nume=:nume, prenume=:prenume, cnp=:cnp, username=:username, specializare=:specializare WHERE id=:iduser', array(':nume'=>$nume, ':prenume'=>$prenume, ':cnp'=>$cnp, ':username'=>$username, ':specializare'=>$specializare, ':iduser'=>$iduser));  
        $err =  "Success!";
}

if (isset($_POST['sterge'])) {
        baza::query('DELETE FROM petvet.login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
        baza::query('DELETE FROM petvet.medici WHERE id=:userid', array(':userid'=>$iduser));
        header('location: index.php');
}

?>

<html>
<head>
	<title>PetVet</title>
	<link rel = "stylesheet" type="text/css" href = "css/stil_login.css"> 
	<style type="text/css">
		#divmare {
				width: 1150px;
				height: 750px;
				margin-left: 100px;
				margin-right: 50px;
				background-color: rgba(255, 255, 255, 0.7);
				
			}
		#div1 {
			width: 450px;
			height: 400px;
			margin-left: 50px;
			background-color: rgba(3, 117, 180, 0);
			float: left;
			
		}
		#div2 {
			width: 450px;
			height: 400px;
			margin-right: 50px;
			margin-left: -50px;
			background-color: rgba(3, 117, 180, 0);
			float: right;
			
		}
	</style>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body style="background-image: url('images/bg3-01.png');">
	<nav class="navbar navbar-dark bg-dark">
        <span class="navbar-text navbar-dark bg-dark" >
		    <font color="#ecf0f1">	Bun venit <?php echo $username;?>!
			</font>
	    </span>
     </nav>
	<br> 
	<br>
	
	<div id="divmare">
		<div id="div1">
		<h4>
		<center>
		<font color="#262228">
		<form action = "my_account.php" method=post>
		<b>Nume:        <br> </b><input type="text" name="nume" value="<?php echo $nume;?>">
		<br>
		<b>Prenume:      <br></b><input type="text" name="prenume" value="<?php echo $prenume;?>">
		<br> 
        <b>Username:      <br></b><input type="text" name="username" value="<?php echo $username;?>">
		<br>
		<b>CNP:          <br></b><input type="text" name="cnp" value="<?php echo $cnp;?>">
		<br>
		<b>Specializare: <br></b><input type="text" name="specializare" value="<?php echo $specializare;?>">
		<br>
		<b>Parola:       <br></b><input type="password" name="parola" value="" placeholder="Parola...">
		<input type="submit" name="update" value="Update" class="button">
        </form>
		</font>
        </center>
		
		</h4>
		</div>
		<div id="div2">
			<center>
			<br>
			<br>
			<br>
			<form action="my_account.php" method="post">
				<input type="submit" name="sterge" value="Sterge Contul" class="button">
			</form>
			<br>
			<form action="logout.php" method="post">
				<input type="submit" name="index" value="Log Out" class="button">
			</form>
			<br>
			<form action="homepage.php" method="post">
				<input type="submit" name="inapoi" value="Inapoi" class="button">
			</form>
			</center>
		</div>
	</div>
	
	
</body>
</html>