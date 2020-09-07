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

if (isset($_POST['adauga'])){
    $nume_interventie = $_POST['interventia'];
    if (baza::query('SELECT denumire FROM petvet.interventii WHERE denumire=:denumire', array(':denumire'=>$nume_interventie))) {
         $id_interventie = baza::query('SELECT id FROM petvet.interventii WHERE denumire=:denumire', array(':denumire'=>$nume_interventie))[0]['id'];
         if (!baza::query('SELECT id FROM petvet.medici_interventii WHERE id_medic=:id_medic AND id_interventie=:id_interventie', array(':id_medic'=>$iduser, ':id_interventie'=>$id_interventie))){
            
            baza::query('INSERT INTO petvet.medici_interventii VALUES (\'\', :id_medic, :id_interventie)', array(':id_medic'=>$iduser, ':id_interventie'=>$id_interventie));
         } else {
             $err1 = "Aveti deja aceasta interventie adaugata!";
         }
    } else {
        $err1 =  "Nu exista aceasta interventie!";
    }
}

if (isset($_POST['inapoi'])){
    header('location: homepage.php');
}

if (isset($_POST['lista_medicamente'])){
    header('location: medicamente.php');
}

if (isset($_POST['lista_interventii'])){
    header('location: interventii.php');
}

?>
<html>
    <head>
        <title>PetVet</title>
	<link rel = "stylesheet" type="text/css" href = "css/stil_login.css"> 
	<style type="text/css">
		#divbutoane {
				width: 1250px;
				height: 120px;
				margin-left: 50px;
				margin-right: 50px;
				background-color: rgba(255, 255, 255, 0.6);
				
			}
		#div1 {
			width: 1250px;
			height: 200px;
			margin-left: 50px;
			background-color: rgba(255, 255, 255, 0.6);
			
			
		}
        #div2 {
			width: 1250px;
			height: 300px;
			margin-left: 50px;
			background-color: rgba(255, 255, 255, 0.6);
			
			
		}
        #div1again {
			width: 1250px;
			height: 100%;
			margin-left: 50px;
			background-color: rgba(255, 255, 255, 0.6);
			
			
		}
		#div12 {
			width: 550px;
			height:100%;
			margin-right: 50px;
			margin-left: 10px;
			background-color: rgba(255, 255, 255, 1);
			float: left;
			
		}
        #div22 {
			width: 550px;
			height: 100%;
			margin-right: 0px;
			margin-left: -50px;
			background-color: rgba(255, 255, 255, 1);
			float: right;
			
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
	</style>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    </head>
    <body style="background-image: url('images/bg4-01.png');">
        <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-text navbar-dark bg-dark" >
		    <font color="#ecf0f1">	INVENTAR
			</font>
	    </span>
     </nav>
	<br> 
	<br>
    <div id = "divbutoane">
    <center>
    <form action="inventar.php" method="post">
    <input type="submit" name="lista_medicamente" value="Medicamente" class="button">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="inapoi" value="Inapoi" class="button"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="lista_interventii" value="Interventii" class="button">
    </form>
    </center>
    </div><br><br>
    <div id = "div1">
    <center>
    <form action="inventar.php" method="post">
        <label for="interventia"><b>Adauga o interventie pentru tine:</b></label>
        <input type="text" name="interventia" ><br>
        <?php echo $err1 . "<br>";?>
        <input type="submit" name="adauga" value="Adauga" class="button">
    </form>
    </center>
    </div><br>
    <br>
    <div id = "div2">
    <center>
    <form action="inventar.php" method="post">
        <label for="cnp_medic"><b>Verifica daca un medic se poate ocupa de toate interventile:</b></label>
        <input type="text" name="cnp_medic" placeholder = "CNP medic..."><br>
        <?php echo $err1 . "<br>";?>
        <input type="submit" name="cauta_medic" value="Cauta" class="button"><br>
        <?php
            if (isset($_POST['cauta_medic'])){
                $cauta_cnp = $_POST['cnp_medic'];
                if(baza::query('SELECT id FROM petvet.medici WHERE cnp=:cnp', array(':cnp'=>$cauta_cnp))) {
                    $id_cauta = baza::query('SELECT id FROM petvet.medici WHERE cnp=:cnp', array(':cnp'=>$cauta_cnp))[0]['id'];
                    $medici = baza::query('SELECT * FROM petvet.medici WHERE (SELECT COUNT(*) FROM petvet.interventii) = (SELECT COUNT(petvet.medici_interventii.id_interventie) FROM petvet.medici_interventii WHERE petvet.medici_interventii.id_medic = :id)', array(':id'=>$id_cauta));
                    $nume_medic = baza::query('SELECT nume FROM petvet.medici WHERE cnp=:cnp', array(':cnp'=>$cauta_cnp))[0]['nume'];
                    $prenume_medic = baza::query('SELECT prenume FROM petvet.medici WHERE cnp=:cnp', array(':cnp'=>$cauta_cnp))[0]['prenume'];
                    if($medici) {
                        echo "<br><h4><b>Da, acest medic: ".$nume_medic." ".$prenume_medic." se ocupa de toate interventiile!</b></h4>";
                    } else {
                        echo "<br><h4><b>Acest medic: ".$nume_medic." ".$prenume_medic." nu se ocupa de toate interventiile!</b></h4>";
                        
                    }
                } else {
                    echo "<br><h4><b>Medic neinregistrat!</b></br>";
                }
            }
        ?>
    </form>
    </center>
    </div><br>
    <div id = "div1again">
    <div id = "div12">
    <center>
    <table>
    <tr>
        <th>Interventiile mele:</th>
    </tr>
    <?php
    $interventii = baza::query('SELECT * FROM petvet.interventii INNER JOIN petvet.medici_interventii ON petvet.interventii.id = petvet.medici_interventii.id_interventie
    WHERE petvet.medici_interventii.id_medic = :idmedic', array(':idmedic'=>$iduser));
    foreach ($interventii as $interventie){
        echo "<tr>";
        echo "<td>".$interventie['denumire']."</td>";
        echo "</tr>";  
    }
    ?>
        </table></center>
        </div>
    <div id = "div22">
    <center>
    <table>
    <tr>
        <th>Medici cu interventii ca ale mele:</th>
    </tr>
    <?php
    $medici = baza::query('SELECT DISTINCT petvet.medici.nume, petvet.medici.prenume FROM petvet.medici INNER JOIN petvet.medici_interventii ON petvet.medici.id = petvet.medici_interventii.id_medic WHERE petvet.medici.id != :idmedic AND petvet.medici_interventii.id_interventie IN (SELECT petvet.interventii.id FROM petvet.interventii INNER JOIN petvet.medici_interventii i ON petvet.interventii.id = petvet.i.id_interventie WHERE petvet.i.id_medic = :idmedic)', array(':idmedic'=>$iduser));

    foreach ($medici as $medic){
                echo "<tr>";
                echo "<td>".$medic['nume']." ".$medic['prenume']."</td>";
                echo "</tr>";  
            
    }
    
    ?>
    </table>
        </center>
        </div>
    </div>
    </body>
</html>
