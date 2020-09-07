<?php
$username = "";
$err = "";
$err1 = "";
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

if (isset($_POST['insert'])) {
        $nume = $_POST['nume'];
        $rasa = $_POST['rasa'];
        $specie = $_POST['specie'];
        $cnp_proprietar = $_POST['cnp_proprietar'];
        
    
        if($nume == "" || $rasa == "" || $specie == "" ) {
             $err = 'Completati toate campurile!'; 
        } else {
            if($cnp_proprietar == "")
            {
                    $id_proprietar = null;
                    baza::query('INSERT INTO petvet.pacienti VALUES (\'\', :nume, :rasa, :specie, :id_proprietar)', array(':nume'=>$nume, ':rasa'=>$rasa, ':specie'=>$specie, ':id_proprietar'=>$id_proprietar));
                echo "SUCCES!";
            } else {
                    if (baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))){
                        $id_proprietar = baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))[0]['id'];
                        baza::query('INSERT INTO petvet.pacienti VALUES (\'\', :nume, :rasa, :specie, :id_proprietar)', array(':nume'=>$nume, ':rasa'=>$rasa, ':specie'=>$specie, ':id_proprietar'=>$id_proprietar));
                        echo "SUCCES!";
                    }   else {
                    $err = 'Proprietarul nu exista!';
                    }
                }
         } 
}

if (isset($_POST['inapoi'])){
    header('location: pacienti.php');
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
		    <font color="#ecf0f1">	Adauga un pacient!
			</font>
	    </span>
     </nav>
	<br> <center>   
<div>
<form action="adauga_pacient.php" method="post">
        <b><label for="nume">Nume</label><br>
        <input type="text" name="nume" value="" placeholder="Nume ..."><p /><br>
        <label for="rasa">Rasa</label><br>   
        <input type="text" name="rasa" value="" placeholder="Rasa ..."><p />
        <label for="specie">Specie</label><br>
        <input type="text" name="specie" value="" placeholder="Specie..."><p />
        <label for="cnp_proprietar">CNP Proprietar</label><br>
        <input type="text" name="cnp_proprietar" value="" placeholder="CNP Proprietar ..."><p />
        </b>
        <?php echo $err; ?><br>
        <input type="submit" name="insert" value="Adauga" class="button">
    </form>
    <form action="adauga_fisa.php" method="post" >
    <input type="submit" name="inapoi" value="Inapoi" class="button">
    </form>
    </div></center>
	<br>
</body>
</html>