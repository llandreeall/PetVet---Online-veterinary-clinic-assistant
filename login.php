<?php
include('classes/baza.php');
$err = "";
if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $parola = $_POST['parola'];
        if($username == 'admin2020') {
            if($parola == 'parola2020') {
                header('location: ./admin/admin.php');
            } else {
                $err = 'Parola de admin gresita!';
            }
        } else {
            if (baza::query('SELECT username FROM petvet.medici WHERE username=:username', array(':username'=>$username))) {
                    if (password_verify($parola, baza::query('SELECT parola FROM petvet.medici WHERE username=:username', array(':username'=>$username))[0]['parola'])) {
                            echo 'Logat!';
                            $cstrong = True;
                            $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                            $user_id = baza::query('SELECT id FROM petvet.medici WHERE username=:username', array(':username'=>$username))[0]['id'];
                            baza::query('INSERT INTO petvet.login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                            setcookie("PVID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                            header('location: homepage.php');
                    } else {
                            $err = 'Parola gresita!';
                    }
            } else {
                    $err =  'Utilizator neinregistrat!';
            }
        }
}
?>
<html>
<head>
	
	<title>PetVet</title>
	<link rel = "stylesheet" type="text/css" href = "css/stil_login.css"> 
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body style="background-image: url('images/bg3-01.png');">
	<nav class="navbar navbar-dark bg-dark">
        <span class="navbar-text navbar-dark bg-dark" >
		    <font color="#ecf0f1">	Intra in cont!
			</font>
	    </span>
     </nav>
	 
	<br> 
	<br>
	<br>
	<br>
	<br> <center>   
	<div>
	<form action="login.php" method="post">
<b><label for="username">Username</label><br>
<input type="text" name="username" value="" placeholder="Username ..."><p />
<br>
<label for="parola">Parola</label><br></b>
<input type="password" name="parola" value="" placeholder="Parola ..."><p />
<?php echo $err; ?><br>
<input type="submit" name="login" value="Login" class="button">
</form>
	</div></center>
	<br>
</body>
</html>


