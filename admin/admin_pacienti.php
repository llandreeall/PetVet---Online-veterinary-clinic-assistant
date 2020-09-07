<?php
include('../classes/baza.php');
session_start();
$err = "";
if (isset($_POST['insert'])) {
        $nume = $_POST['nume'];
        $rasa = $_POST['rasa'];
        $specie = $_POST['specie'];
        $cnp_proprietar = $_POST['cnp_proprietar'];
        
    
        if($nume == "" || $rasa == "" || $specie == "" || $cnp_proprietar == "" ) {
             $err = 'Completati toate campurile!'; 
        } else {
            if (baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))) {
                $id_proprietar = baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))[0]['id'];
                baza::query('INSERT INTO petvet.pacienti VALUES (\'\', :nume, :rasa, :specie, :id_proprietar)', array(':nume'=>$nume, ':rasa'=>$rasa, ':specie'=>$specie, ':id_proprietar'=>$id_proprietar));
            } else {
                $err = 'Proprietarul nu exista!';
            }
         } 
}


        
        if (isset($_POST['actualizeaza'])) {
                $id = $_SESSION['id'];
                $nume = $_POST['nume'];
                $rasa = $_POST['rasa'];
                $specie = $_POST['specie'];
                $cnp_proprietar = $_POST['cnp_proprietar'];
                
                if (!baza::query('SELECT cnp FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar)) || $cnp_proprietar == "") {
                    $id_proprietar = null;
                    $err = "CNP-ul proprietarului nu exista, asa ca i s-a dat valoarea NULL";
                } else {
                    $id_proprietar = baza::query('SELECT id FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp_proprietar))[0]['id'];
                }
                
                if($id_proprietar == null)
                    baza::query('UPDATE petvet.pacienti SET nume=:nume, rasa=:rasa, specie=:specie, id_proprietar=null WHERE id=:iduser', array(':nume'=>$nume, ':rasa'=>$rasa, ':specie'=>$specie,  ':iduser'=>$id));  
                else
                    baza::query('UPDATE petvet.pacienti SET nume=:nume, rasa=:rasa, specie=:specie, id_proprietar=:id_proprietar WHERE id=:iduser', array(':nume'=>$nume, ':rasa'=>$rasa, ':specie'=>$specie, ':id_proprietar'=>$id_proprietar, ':iduser'=>$id)); 
        }

        if (isset($_POST['delete'])){
            header('location: admin_pacienti.php');
        }


?>
<html>
    <head>
        <title>PetVet ~ ADMIN</title>
	<style type="text/css">
		
		.navbar {
		  overflow: hidden;
		  background-color: #333;
		  position: fixed;
		  top: 0;
		  width: 100%;
		  
		}
		.navbar-text {
		  position: fixed;
		  width: 100%;
		  left: 0;
		  top: 0;
		  text-align: center;
		  font-size: 20px;
		 }
        #divreg {
          border-radius: 5px;
		  background-color: rgba(0, 80, 100, 0.1);
		  padding: 20px;
          width: 500px;
          height: 600px;
		  margin-left: 50px;
          float: left;
        }
        #divmaintain {
          border-radius: 5px;
		  background-color: rgba(0, 80, 100, 0.1);
		  padding: 20px;
          width: 500px;
          height: 600px;
		  margin-left: 50px;
          margin-right: 100px;
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
    <body>
       <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
        <span class="navbar-text navbar-light" style="background-color: #e3f2fd;">
		    <a href = "admin_medici.php" > Medici   </a>&nbsp;
            <a href = "admin_pacienti.php" > Pacienti   </a> &nbsp;
            <a href = "admin_interventii.php" > Interventii   </a>  &nbsp;
            <a href = "admin_medicamente.php" > Medicamente   </a>  &nbsp;
            <a href = "admin_proprietari.php" > Proprietari   </a>  &nbsp;
            <a href = "admin.php" > Inapoi   </a>  &nbsp;
	    </span>
     </nav>
	<br> 
	<br>

    <table>
      <tr>
        <th>Id</th>
        <th>Nume</th>
        <th>Rasa</th>
        <th>Specie</th>
        <th>Id_Proprietar</th>
        <th>UPDATE</th>
        <th>DELETE</th>
      </tr>
      <?php
    
        $pacienti = baza::query('SELECT * FROM petvet.pacienti', array());
        foreach ($pacienti as $pacient) {
            $id = $pacient['id'];
            echo "<tr>";
            echo "<td>".$pacient['id']."</td>";
            echo "<td>".$pacient['nume']."</td>";
            echo "<td>".$pacient['rasa']."</td>";
            echo "<td>".$pacient['specie']."</td>";
            echo "<td>".$pacient['id_proprietar']."</td>";
            echo "<td>"."
            <form action="."admin_pacienti.php?id=".$pacient['id']." method="."post".">
                <input type = "."submit"." name="."update"." value="."UPDATE"." >
            </form>
            "."</td>";
            echo "<td>"."
            <form action="."admin_pacienti.php?id=".$pacient['id']." method="."post".">
                <input type = "."submit"." name="."delete"." value="."DELETE"." >
            </form>
            "."</td>";
            echo "</tr>";
        }
        ?>
</table>
    <br> 
	<br>
    <div id = "divreg">
        <center>   
        <form action="admin_pacienti.php" method="post">
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
        <input type="submit" name="insert" value="INSERT" >
        </form>
        </center>
    </div>
    <?php
        if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (isset($_POST['update'])) {
            $_SESSION['id'] = $id;
            $rasa = baza::query('SELECT rasa FROM petvet.pacienti WHERE id=:iduser', array(':iduser'=>$id))[0]['rasa'];
            $nume = baza::query('SELECT nume FROM petvet.pacienti WHERE id=:iduser', array(':iduser'=>$id))[0]['nume'];
            $specie = baza::query('SELECT specie FROM petvet.pacienti WHERE id=:iduser', array(':iduser'=>$id))[0]['specie'];
            $id_proprietar = baza::query('SELECT id_proprietar FROM petvet.pacienti WHERE id=:iduser', array(':iduser'=>$id))[0]['id_proprietar'];
            if($id_proprietar != null)
                $cnp_proprietar = baza::query('SELECT cnp FROM petvet.proprietari WHERE id=:iduser', array(':iduser'=>$id_proprietar))[0]['cnp'];
            else
                $cnp_proprietar = "";
            
            echo "
            <div id = "."divmaintain".">
            <center>   
            <form action="."admin_pacienti.php?id=".$pacient['id']." method="."post".">
            <b><label for="."nume".">Nume</label><br>
            <input type="."text"." name="."nume"." value=".$nume." placeholder="."Nume ..."."><p />
            <label for="."rasa".">Rasa</label><br>   
            <input type="."text"." name="."rasa"." value=".$rasa." placeholder="."Rasa ..."."><p />
            <label for="."specie".">Specie</label><br>
            <input type="."text"." name="."specie"." value=".$specie." placeholder="."Specie..."."><p />
            <label for="."cnp_proprietar".">CNP Prorpietar</label><br>
            <input type="."text"." name="."cnp_proprietar"." value=".$cnp_proprietar." placeholder="."CNP Proprietar ..."."><p />
            
            ".$err."<br>
            <input type="."submit"." name="."actualizeaza"." value="."UPDATE"." >
            </form>
            </center>
        </div>
            ";
        }
            
         if (isset($_POST['delete'])) {
               baza::query('DELETE FROM petvet.fisa_medicala WHERE id_pacient=:pacientid', array(':pacientid'=>$id));
               baza::query('DELETE FROM petvet.pacienti WHERE id=:pacientid', array(':pacientid'=>$id));
               header('location: admin_pacienti.php');
        }
        }
        ?>
    
    </body>
</html>