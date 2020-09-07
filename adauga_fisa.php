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

if (isset($_POST['createfisa'])) {
        $nume_pacient = $_POST['nume'];
        $cnp_proprietar = $_POST['pnume'];
        $nume_medicament = $_POST['nume_medicament'];
        $afectiune = $_POST['afectiune'];
        $interventie = $_POST['interventie'];
        $data = $_POST['data'];
    
        if($nume_pacient == "" || $cnp_proprietar == "" || $afectiune == "" || $data == "") {
             $err = 'Completati toate campurile! Interventia si medicamentul sunt optionale!'; 
        } else {
            if (baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))) {
                $id_proprietar = baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))[0]['id'];
                if (baza::query('SELECT id FROM petvet.pacienti WHERE nume=:nume AND id_proprietar=:id_proprietar', array(':nume'=>$nume_pacient, ':id_proprietar'=>$id_proprietar))) {
                    $id_pacient = baza::query('SELECT id FROM petvet.pacienti WHERE nume=:nume AND id_proprietar=:id_proprietar', array(':nume'=>$nume_pacient, ':id_proprietar'=>$id_proprietar))[0]['id'];
                    if(!baza::query('SELECT * FROM petvet.fisa_medicala WHERE data=:data AND id_pacient = :id', array(':data'=>$data, ':id'=>$id_pacient))){
                    if($nume_medicament != "" && $interventie != "") {
                        if (baza::query('SELECT id FROM petvet.medicamente WHERE denumire=:denumire', array(':denumire'=>$nume_medicament))){
                             $id_medicament = baza::query('SELECT id FROM petvet.medicamente WHERE denumire=:denumire', array(':denumire'=>$nume_medicament))[0]['id'];
                             $specie_destinata = baza::query('SELECT specie_destinata FROM petvet.medicamente WHERE denumire=:denumire', array(':denumire'=>$nume_medicament))[0]['specie_destinata'];
                             $specie_proprietar = baza::query('SELECT specie FROM petvet.pacienti WHERE id=:id', array(':id'=>$id_pacient))[0]['specie'];
                             if($specie_destinata == 'toate' || $specie_destinata == $specie_proprietar) {
                                 if (baza::query('SELECT id FROM petvet.interventii WHERE denumire=:denumire', array(':denumire'=>$interventie))){
                                     $id_interventie = baza::query('SELECT id FROM petvet.interventii WHERE denumire=:denumire', array(':denumire'=>$interventie))[0]['id'];
                                     baza::query('INSERT INTO petvet.fisa_medicala VALUES (\'\', :afectiune, :data, :id_pacient, :id_medicament, :id_interventie)', array(':afectiune'=>$afectiune, ':data'=>$data, ':id_pacient'=>$id_pacient, ':id_medicament'=>$id_medicament, ':id_interventie'=>$id_interventie));
                                     $err = "Success!";
                                } else {
                                    $err = 'Interventia nu exista!';
                                }
                             } else {
                                 $err = 'Medicamentul mentionat e destinat altei specii!';
                             }
                        } else {
                            $err = 'Medicamentul nu exista!';
                        }
                    } else {
                        if($nume_medicament == "") {$id_medicament = "";} else
                        {
                            if (baza::query('SELECT id FROM petvet.medicamente WHERE denumire=:denumire', array(':denumire'=>$nume_medicament))){
                                $specie_destinata = baza::query('SELECT specie_destinata FROM petvet.medicamente WHERE denumire=:denumire', array(':denumire'=>$nume_medicament))[0]['specie_destinata'];
                                $specie_pacient = baza::query('SELECT specie FROM petvet.pacienti WHERE id=:id', array(':id'=>$id_pacient))[0]['specie'];
                                if($specie_destinata == 'toate' || $specie_destinata == $specie_pacient) {
                                    $id_medicament = baza::query('SELECT id FROM petvet.medicamente WHERE denumire=:denumire', array(':denumire'=>$nume_medicament))[0]['id'];
                                } else {
                                    $err = 'Medicamentul mentionat e destinat altei specii!';
                                }
                            } else {
                                $err = 'Medicamentul nu exista!';
                            }
                        }
                        if($interventie == "") {$id_interventie = "";} else
                        {
                            if (baza::query('SELECT id FROM petvet.interventii WHERE denumire=:denumire', array(':denumire'=>$interventie))){
                                 $id_interventie = baza::query('SELECT id FROM petvet.interventii WHERE denumire=:denumire', array(':denumire'=>$interventie))[0]['id'];
                            } else {
                                $err = 'Interventia nu exista!';
                            }
                        }
                        if($err != 'Medicamentul nu exista!' && $err != 'Interventia nu exista!' && $err != 'Medicamentul mentionat e destinat altei specii!') {
                            baza::query('INSERT INTO petvet.fisa_medicala VALUES (\'\', :afectiune, :data, :id_pacient, :id_medicament, :id_interventie)', array(':afectiune'=>$afectiune, ':data'=>$data, ':id_pacient'=>$id_pacient, ':id_medicament'=>$id_medicament, ':id_interventie'=>$id_interventie));
                            $err = "Success!";
                        }
                    }
                        } else {
                            $err = 'Exista deja o fisa introdusa pe data respectiva pentru acest pacient!';
                        }
                    
                    } else {
                        $err = 'Pacientul nu exista!';
                }
             } else {
                    $err = 'Proprietarul nu exista!';
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
		    <font color="#ecf0f1">	Adauga o fisa medicala!
			</font>
	    </span>
     </nav>
	<br> <center>   
<div>
<form action="adauga_fisa.php" method="post">
    <b><label for="nume">Nume Pacient</label><br>
    <input type="text" name="nume" value="" placeholder="Nume Pacient..."><p />
    <label for="pnume">CNP Proprietar</label><br>   
    <input type="text" name="pnume" value="" placeholder="CNP Proprietar ..."><p />
    <label for="nume_medicament">Medicament administrat</label><br>
    <input type="text" name="nume_medicament" value="" placeholder="Medicament Administrat..."><p />
    <label for="afectiune">Afectiune</label><br>
    <input type="text" name="afectiune" value="" placeholder="Afectiune ..."><p />
    <label for="interventie">Interventie</label><br>
    <input type="text" name="interventie" value="" placeholder="Interventie ..."><p />
    <label for="data">Data fisei</label><br>
    <input type="date" name="data" value="" placeholder="Data..."><p /></b>
    <?php echo $err; ?><br>
    <input type="submit" name="createfisa" value="Adauga" class="button">
    </form>
    <form action="adauga_fisa.php" method="post">
    <input type="submit" name="inapoi" value="Inapoi" class="button">
    </form>
    </div></center>
	<br>
</body>
</html>