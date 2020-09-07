<?php
$username = "";
$err = "";
$err1 = "";
$suma[0] = "";
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


if (isset($_POST['cauta1'])){
    $cnp_proprietar = $_POST['cnp_proprietar'];
    $id_proprietar = baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))[0]['id'];
    $suma = baza::query('SELECT SUM(petvet.interventii.pret) FROM petvet.interventii INNER JOIN petvet.fisa_medicala ON petvet.interventii.id = petvet.fisa_medicala.id_interventie
    INNER JOIN petvet.pacienti ON petvet.fisa_medicala.id_pacient = petvet.pacienti.id
    INNER JOIN petvet.proprietari ON petvet.pacienti.id_proprietar = petvet.proprietari.id
    WHERE petvet.proprietari.id = :idproprietar', array(':idproprietar'=>$id_proprietar))[0];
    
}

if (isset($_POST['inapoi'])){
    header('location: homepage.php');
}

if (isset($_POST['adauga_pacient'])){
    header('location: adauga_pacient.php');
}

if (isset($_POST['fisa'])){
    header('location: adauga_fisa.php');
}

?>
<html>
    <head>
	
	<title>PetVet</title>
	<link rel = "stylesheet" type="text/css" href = "css/stil_register.css"> 
    <style type="text/css">
		#divbutoane {
				width: 1250px;
				height: 120px;
				margin-left: 50px;
				margin-right: 50px;
				background-color: rgba(255, 255, 255, 0.6);
				position:static;
			}
		#div1 {
			width: 1250px;
			height: 300px;
			margin-left: 50px;
			background-color: rgba(255, 255, 255, 0.6);
			position:static;
			
		}
        #div1again {
			width: 1250px;
			height: 300px;
			margin-left: 50px;
			background-color: rgba(255, 255, 255, 0.6);
			position:static;
			
		}
		#div12 {
			width: 1250px;
			height: 200px;
			margin-left: 50px;
			background-color: rgba(255, 255, 255, 0.6);
			position:static;
		}
        #div22 {
			width: 1250px;
			height: 100%;
			margin-right: 0px;
			margin-left: 50px;
			background-color: rgba(255, 255, 255, 1);
			position:static;
			
		}
        #divsum {
			width: 100px;
			height: 10px;
            background-color: rgba(255, 255, 255, 1);
		}
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 4px;
        }

        tr:nth-child(even) {
          background-color: #dddddd;
        }
        
        .button1 {
		  position: relative;
		  background-color: #333;
		  border: none;
		  font-size: 12px;
		  font-weight: bold;
		  color: #ecf0f1;
		  padding: 5px;
		  width: 80px;
		  text-align: center;
		  -webkit-transition-duration: 0.4s; 
		  transition-duration: 0.4s;
		  text-decoration: none;
		  overflow: hidden;
		  cursor: pointer;
		}

		.button1:after {
		  content: "";
		  background: #7f8c8d;
		  display: block;
		  position: absolute;
		  padding-top: 300%;
		  padding-left: 350%;
		  margin-left: -20px;
		  margin-top: -120%;
		  opacity: 0;
		  transition: all 0.8s
		}

		.button1:active:after {
		  padding: 0;
		  margin: 0;
		  opacity: 1;
		  transition: 0s
		}
	</style>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body style="background-image: url('images/bg2-02.png');">
    
<nav class="navbar navbar-dark bg-dark">
        <span class="navbar-text navbar-dark bg-dark" >
		    <font color="#ecf0f1">	Administrare Pacienti
			</font>
	    </span>
     </nav>
	<br>
    <br>
<div id = "divbutoane">
    <center>
    <form action="pacienti.php" method="post">
    <input type="submit" name="adauga_pacient" value="+Pacient" class="button">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="inapoi" value="Inapoi" class="button"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="fisa" value="+Fisa" class="button">
    </form>
    </center>
    </div><br><br>
    

<div id = "div1">
<center>    
<form action="pacienti.php" method="post">
        <label for="proprietar"><b>Afla cat a achitat un proprietar in total:</b></label><br>
        <input type="text" name="cnp_proprietar" ><br>
        <input type="submit" name="cauta1" value="Cauta" class="button"><br>
        <?php 
            if($suma[0])
                echo "Acest proprietar a achitat <div id = "."divsum".">".$suma[0]." lei<br> </div>"; ?>
        <?php echo $err1; ?>
    </form><br>
</center>
    </div><br>
 <div id = "div1again">
<center>
<form action="pacienti.php" method="post">
        <label for="proprietar"><b>Cauta animalele de companie ale unui proprietar:</b></label><br>
        <input type="text" name="proprietar" ><br><?php echo $err1; ?><br>
        <input type="submit" name="cauta" value="Cauta" class="button">
        
    </form><br>
</center>
    </div><br>
<div id = "div12">
    <center>
    <form action="pacienti.php" method="post">
    <label for="cauta_pastile"><b>Afiseaza fisele medicale unde pastilele sunt pe terminate(sub 30 de bucati)</b></label>
    <input type="submit" name="cauta_pastile" value="Afiseaza" class="button1"><br>
    <label for="fara"><b>Afiseaza pacientii fara proprietar</b></label>
    <input type="submit" name="fara" value="Afiseaza" class="button1">
    </form>
    </center>
    </div><br><br>
<div id = "div22"><center>
<h4><b>Lista fiselor medicale pentru pacientii cu URGENTE impreuna cu proprietarii: </b></h4>
<?php

        $fise = baza::query('SELECT * FROM petvet.fisa_medicala 
        INNER JOIN petvet.interventii ON petvet.fisa_medicala.id_interventie = petvet.interventii.id
        WHERE petvet.interventii.denumire=:denumire', array(':denumire'=>"Interventie de Urgenta"));
        if($fise) {
            echo "<table>
              <tr>
                <th>Nume Pacient</th>
                <th>Afectiune</th>
                <th>Data</th>
                <th>Medicament administrat</th>
                <th>Nume Proprietar</th>
                <th>CNP Proprietar</th>
              </tr>";
            foreach ($fise as $fisa) {
                $id_medicament = $fisa['id_medicament'];
                $id_interventie = $fisa['id_interventie'];
                $id_pacient = $fisa['id_pacient'];
                if($id_medicament == 0)
                    $nume_medicament = "-";
                else
                    $nume_medicament = baza::query('SELECT denumire FROM petvet.medicamente WHERE id=:id', array(':id'=>$id_medicament))[0]['denumire'];
                $nume_proprietar = baza::query('SELECT petvet.proprietari.nume FROM petvet.proprietari
                INNER JOIN petvet.pacienti ON petvet.proprietari.id = petvet.pacienti.id_proprietar
                WHERE petvet.pacienti.id=:id', array(':id'=>$id_pacient))[0]['nume'];
                $prenume_proprietar = baza::query('SELECT petvet.proprietari.prenume FROM petvet.proprietari
                INNER JOIN petvet.pacienti ON petvet.proprietari.id = petvet.pacienti.id_proprietar
                WHERE petvet.pacienti.id=:id', array(':id'=>$id_pacient))[0]['prenume'];
                $cnp_proprietar = baza::query('SELECT petvet.proprietari.cnp FROM petvet.proprietari
                INNER JOIN petvet.pacienti ON petvet.proprietari.id = petvet.pacienti.id_proprietar
                WHERE petvet.pacienti.id=:id', array(':id'=>$id_pacient))[0]['cnp'];
                $nume_pacient = baza::query('SELECT nume FROM petvet.pacienti WHERE id=:id', array(':id'=>$id_pacient))[0]['nume'];
                echo "<tr>";
                echo "<td>".$nume_pacient."</td>";
                echo "<td>".$fisa['afectiune']."</td>";
                echo "<td>".$fisa['data']."</td>";
                echo "<td>".$nume_medicament."</td>";
                echo "<td>".$nume_proprietar." ".$prenume_proprietar."</td>";
                echo "<td>".$cnp_proprietar."</td>";
                echo "</tr>";
            }
        } else {
            echo "Momentan nu exista pacienti cu urgente inregistrati!";
        }
?>
  </center>
    </div>
<br><br><br>

<?php
    if (isset($_POST['cauta'])){
    echo "<center>";
    $cnp_proprietar = $_POST['proprietar'];
    if (baza::query('SELECT cnp FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))){
        $id_proprietar = baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))[0]['id'];
        if(baza::query('SELECT * FROM petvet.pacienti INNER JOIN petvet.proprietari ON petvet.pacienti.id_proprietar = petvet.proprietari.id WHERE petvet.proprietari.id = :idproprietar', array(':idproprietar'=>$id_proprietar))){
            $pacienti = baza::query('SELECT petvet.pacienti.id, petvet.pacienti.nume, petvet.pacienti.rasa, petvet.pacienti.specie FROM petvet.pacienti INNER JOIN petvet.proprietari ON petvet.pacienti.id_proprietar = petvet.proprietari.id WHERE petvet.proprietari.id = :idproprietar', array(':idproprietar'=>$id_proprietar));
            echo "<table>";
            echo "<br><h4><b>Lista pacientilor ce au proprietarul cu CNP-ul: ".$cnp_proprietar." </b></h4><br>";
             echo" <tr>
                <th>Nume</th>
                <th>Rasa</th>
                <th>Specie</th>
                <th>Fise Medicale</th>
              </tr>";
                foreach ($pacienti as $pacient) {
                    $id_pacient = $pacient['id'];
                    echo "<tr>";
                    echo "<td>".$pacient['nume']."</td>";
                    echo "<td>".$pacient['rasa']."</td>";
                    echo "<td>".$pacient['specie']."</td>";
                    echo "<td>"."
                    <form action="."fisa_pacient.php?id=".$pacient['id']." method="."post".">
                        <input type = "."submit"." name="."fisa"." value="."VEZI"." class = "."button1".">
                    </form>
                    "."</td>";
                    echo "</tr>";
                }
            echo "</table>";
        } else {
            $err1 = "Proprietarul nu are animale de companie!";
        }
    } else {
        $err1 = "Proprietarul nu exista!";
    }
 
}
    
    if (isset($_POST['cauta_pastile'])){
        echo "<center>";
        $fise = baza::query('SELECT * FROM petvet.fisa_medicala 
        WHERE 30 > (SELECT bucati FROM petvet.medicamente WHERE petvet.medicamente.id = petvet.fisa_medicala.id_medicament)', array());
        if($fise) {
            echo "<table><br><h4><b>Lista fiselor cu medicamentele pe terminate (sub 30 de bucati) </b></h4><br>
              <tr>
                <th>Nume Pacient</th>
                <th>Afectiune</th>
                <th>Data</th>
                <th>Medicament administrat</th>
                <th>Interventie</th>
                <th>Nume Proprietar</th>
                <th>CNP Proprietar</th>
              </tr>";
            foreach ($fise as $fisa) {
                $id_medicament = $fisa['id_medicament'];
                $id_interventie = $fisa['id_interventie'];
                $id_pacient = $fisa['id_pacient'];
                if($id_medicament == 0)
                    $nume_medicament = "-";
                else
                    $nume_medicament = baza::query('SELECT denumire FROM petvet.medicamente WHERE id=:id', array(':id'=>$id_medicament))[0]['denumire'];
                if($id_interventie == 0)
                    $nume_interventie = "-";
                else
                    $nume_interventie = baza::query('SELECT denumire FROM petvet.interventii WHERE id=:id', array(':id'=>$id_interventie))[0]['denumire'];
                $nume_proprietar = baza::query('SELECT petvet.proprietari.nume FROM petvet.proprietari
                INNER JOIN petvet.pacienti ON petvet.proprietari.id = petvet.pacienti.id_proprietar
                WHERE petvet.pacienti.id=:id', array(':id'=>$id_pacient))[0]['nume'];
                $prenume_proprietar = baza::query('SELECT petvet.proprietari.prenume FROM petvet.proprietari
                INNER JOIN petvet.pacienti ON petvet.proprietari.id = petvet.pacienti.id_proprietar
                WHERE petvet.pacienti.id=:id', array(':id'=>$id_pacient))[0]['prenume'];
                $cnp_proprietar = baza::query('SELECT petvet.proprietari.cnp FROM petvet.proprietari
                INNER JOIN petvet.pacienti ON petvet.proprietari.id = petvet.pacienti.id_proprietar
                WHERE petvet.pacienti.id=:id', array(':id'=>$id_pacient))[0]['cnp'];
                $nume_pacient = baza::query('SELECT nume FROM petvet.pacienti WHERE id=:id', array(':id'=>$id_pacient))[0]['nume'];
                echo "<tr>";
                echo "<td>".$nume_pacient."</td>";
                echo "<td>".$fisa['afectiune']."</td>";
                echo "<td>".$fisa['data']."</td>";
                echo "<td>".$nume_medicament."</td>";
                echo "<td>".$nume_interventie."</td>";
                echo "<td>".$nume_proprietar." ".$prenume_proprietar."</td>";
                echo "<td>".$cnp_proprietar."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Momentan medicamentele sunt suficiente!";
        }
    }
    
    if (isset($_POST['fara'])){
        echo "<center>";
        $pacienti = baza::query('SELECT * FROM petvet.pacienti WHERE id NOT IN (SELECT petvet.pacienti.id FROM petvet.pacienti INNER JOIN petvet.proprietari ON petvet.pacienti.id_proprietar = petvet.proprietari.id)', array());
        if($pacienti) {
            echo "<table><br><h4><b>Lista pacientilor fara proprietari </b></h4><br>
              <tr>
                <th>Nume Pacient</th>
                <th>Rasa</th>
                <th>Specie</th>
                <th>Fise Medicale</th>
              </tr>";
            foreach ($pacienti as $pacient) {
                echo "<tr>";
                echo "<td>".$pacient['nume']."</td>";
                echo "<td>".$pacient['rasa']."</td>";
                echo "<td>".$pacient['specie']."</td>";
                echo "<td>"."
                    <form action="."fisa_pacient.php?id=".$pacient['id']." method="."post".">
                        <input type = "."submit"." name="."fisa"." value="."VEZI"." class = "."button1".">
                    </form>
                    "."</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<table><br><h4><b>Toti pacientii inregistrati au un proprietar!</b></h4><br></table>";
        }
    }
    ?>   
</body>
</html>