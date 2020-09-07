<?php
include('classes/baza.php');
$err = "";
if (isset($_POST['createaccount'])) {
        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $cnp = $_POST['cnp'];
        $username = $_POST['username'];
        $parola = $_POST['parola'];
        $specializare = $_POST['specializare'];
    
        if($nume == "" || $prenume == "" || $cnp == "" || $username == "" || $parola == "" || $specializare == "") {
             $err = 'Completati toate campurile!'; 
        } else {
            if (!baza::query('SELECT username FROM petvet.medici WHERE username=:username', array(':username'=>$username))) {
                 if (!baza::query('SELECT username FROM petvet.medici WHERE cnp=:cnp', array(':cnp'=>$cnp))) {

                    baza::query('INSERT INTO petvet.medici VALUES (\'\', :nume, :prenume, :cnp, :username, :parola, :specializare)', array(':nume'=>$nume, ':prenume'=>$prenume, ':cnp'=>$cnp, ':username'=>$username, ':parola'=>password_hash($parola, PASSWORD_BCRYPT), ':specializare'=>$specializare));
                    echo "Success!";
                    } else {
                        $err = 'CNP-ul exista deja!';
                }
             } else {
                    $err = 'Utilizatorul exista deja!';
            }
         } 
}
?>

<html>
<head>
	
	<title>PetVet</title>
	<link rel = "stylesheet" type="text/css" href = "css/stil_register.css"> 
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body style="background-image: url('images/bg2-02.png');">
	<nav class="navbar navbar-dark bg-dark">
        <span class="navbar-text navbar-dark bg-dark" >
		    <font color="#ecf0f1">	Inregistreaza-te!
			</font>
	    </span>
     </nav>
	<br> <center>   
	<div>
	<form action="create_account.php" method="post">
    <b><label for="nume">Nume</label><br>
    <input type="text" name="nume" value="" placeholder="Nume ..."><p />
    <label for="prenume">Prenume</label><br>   
    <input type="text" name="prenume" value="" placeholder="Prenume ..."><p />
    <label for="cnp">CNP</label><br>
    <input type="text" name="cnp" value="" placeholder="CNP..."><p />
    <label for="username">Username</label><br>
    <input type="text" name="username" value="" placeholder="Username ..."><p />
    <label for="parola">Parola</label><br>
    <input type="password" name="parola" value="" placeholder="Parola ..."><p />
    <label for="specializare">Specializare</label><br>
    <input type="text" name="specializare" value="" placeholder="Specializare..."><p /></b>
    <?php echo $err; ?><br>
    <input type="submit" name="createaccount" value="Inregistrare" class="button">
    </form>
    <form action="index.php" method="post">
    <input type="submit" name="inapoi" value="Inapoi" class="button">
    </form>
	</div></center>
	<br>
</body>
</html>
