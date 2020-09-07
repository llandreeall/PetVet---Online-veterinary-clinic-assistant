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
if (isset($_GET['id'])){
    $id_pacient = $_GET['id'];
    $nume_pacient = baza::query('SELECT nume FROM petvet.pacienti WHERE id=:id', array(':id'=>$id_pacient))[0]['nume'];
    $id_proprietar = baza::query('SELECT id_proprietar FROM petvet.pacienti WHERE id=:id', array(':id'=>$id_pacient))[0]['id_proprietar'];
    if($id_proprietar != NULL)
    {$nume_proprietar = baza::query('SELECT nume FROM petvet.proprietari WHERE id=:id', array(':id'=>$id_proprietar))[0]['nume'];
    $prenume_proprietar = baza::query('SELECT prenume FROM petvet.proprietari WHERE id=:id', array(':id'=>$id_proprietar))[0]['prenume']; }  
    else {
        $nume_proprietar = "-";
        $prenume_proprietar = "-";
    }
}
if (isset($_POST['inapoi'])){
    header('location: pacienti.php');
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
        #div1again {
			width: 1250px;
			height: 100%;
			margin-left: 50px;
			background-color: rgba(255, 255, 255, 0.6);
			
			
		}
		#div12 {
			width: 1250px;
			height:50%;
            margin-left: 50px;
			background-color: rgba(255, 255, 255, 1);
			
		}
        #div22 {
			width: 1250px;
			height: 100%;
			margin-left: 50px;
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
		    <font color="#ecf0f1">	Fisele medicala a pacientului <?php echo $nume_pacient;?> | Proprietar: <?php echo $nume_proprietar." ".$prenume_proprietar;?>
			</font>
	    </span>
     </nav>
	<br> 
	<br>
<?php 
    if (isset($_GET['id'])){
    $id_pacient = $_GET['id'];
    $fise = baza::query('SELECT * FROM petvet.fisa_medicala WHERE id_pacient=:id', array(':id'=>$id_pacient));
    if($fise) {
        echo "<br><div id = "."div22"."><center><table>
          <tr>
            
            <th>Afectiune</th>
            <th>Data</th>
            <th>Medicament administrat</th>
            <th>Interventie</th>
            <th>Vezi medici disponibili</th>
          </tr>";
        foreach ($fise as $fisa) {
            $id_medicament = $fisa['id_medicament'];
            $id_interventie = $fisa['id_interventie'];
            if($id_medicament == 0)
                $nume_medicament = "-";
            else
                $nume_medicament = baza::query('SELECT denumire FROM petvet.medicamente WHERE id=:id', array(':id'=>$id_medicament))[0]['denumire'];
            if($id_interventie == 0)
                $nume_interventie = "-";
            else
                $nume_interventie = baza::query('SELECT denumire FROM petvet.interventii WHERE id=:id', array(':id'=>$id_interventie))[0]['denumire'];
            $nume_pacient = baza::query('SELECT nume FROM petvet.pacienti WHERE id=:id', array(':id'=>$id_pacient))[0]['nume'];
            echo "<tr>";
            
            echo "<td>".$fisa['afectiune']."</td>";
            echo "<td>".$fisa['data']."</td>";
            echo "<td>".$nume_medicament."</td>";
            echo "<td>".$nume_interventie."</td>";
            echo "<td>"."
            <form action="."fisa_pacient.php?id=".$id_pacient."&id_fisa=".$fisa['id']." method="."post".">
                        <input type = "."submit"." name="."vezi_medici"." value="."VEZI"." class = "."button1".">
            </form>
                    "."</td>";
            echo "</tr>";
        }
        echo "</table><br>";
        if (isset($_POST['vezi_medici'])){
            if (isset($_GET['id_fisa'])) {
                if(baza::query('SELECT id_interventie FROM petvet.fisa_medicala WHERE id = :id',array(':id'=>$_GET['id_fisa']))[0]['id_interventie'] == 0) {
                    echo "<h4><b>In cadrul acestei fise medicale nu s-a efectuat nicio interventie</h4></b><br>";
                } else {
                    $medici = baza::query('SELECT * FROM petvet.medici 
                    WHERE id IN (SELECT id_medic FROM petvet.medici_interventii WHERE id_interventie = (SELECT id_interventie FROM petvet.fisa_medicala WHERE id = :id))', array(':id'=>$_GET['id_fisa']));
                    $nume_interventie = baza::query('SELECT denumire FROM petvet.interventii WHERE id = (SELECT id_interventie FROM petvet.fisa_medicala WHERE id = :id)',array(':id'=>$_GET['id_fisa']))[0]['denumire'];
                    echo "<h4><b>Medicii disponibili pentru interventia: ".$nume_interventie."</h4></b><br>";
                    echo "<table>
                      <tr>
                        <th>Nume</th>
                        <th>Prenume</th>
                        <th>CNP</th>
                        <th>Specializare</th>
                      </tr>";
                        foreach ($medici as $medic) {
                            echo "<tr>";
                            echo "<td>".$medic['nume']."</td>";
                            echo "<td>".$medic['prenume']."</td>";
                            echo "<td>".$medic['cnp']."</td>";
                            echo "<td>".$medic['specializare']."</td>";
                            echo "</tr>";
                        }
                    echo "</table>";
                }
            }
        }
        echo "<br><form action="."fisa_pacient.php?id=".$id_pacient." method="."post".">
            <input type="."submit"." name="."inapoi"." value="."Inapoi"." class="."button"."> 
            </form></center>";
        echo "</div>";
        
    } else {
        $err1 = 'Pacientul nu are fise medicale inregistrate!';
    }
}
        if($err1)
        {  
            echo "<br><div id = "."div12"."><center><h4><b>".$err1."</h4></b>
            <br><form action="."fisa_pacient.php?id=".$id_pacient." method="."post".">
            <input type="."submit"." name="."inapoi"." value="."Inapoi"." class="."button"."> 
            </form></center></div>
            ";}
        ?>
    </body>
</html>