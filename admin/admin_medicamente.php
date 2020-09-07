<?php
include('../classes/baza.php');
session_start();
$err = "";
if (isset($_POST['insert'])) {
        $denumire = $_POST['denumire'];
        $descriere = $_POST['descriere'];
        $bucati = $_POST['bucati'];
        $specie_destinata = $_POST['specie_destinata'];
    
        if($denumire == "" || $descriere == "" || $bucati == "" || $specie_destinata == "") {
             $err = 'Completati toate campurile!'; 
        } else {
            if (!baza::query('SELECT denumire FROM petvet.medicamente WHERE denumire=:denumire', array(':denumire'=>$denumire))) {
            
                baza::query('INSERT INTO petvet.medicamente VALUES (\'\', :denumire, :descriere, :bucati, :specie_destinata)', array(':denumire'=>$denumire, ':descriere'=>$descriere, ':bucati'=>$bucati, ':specie_destinata'=>$specie_destinata));
                $err =  "Success!";
                    
             } else {
                    $err = 'Medicamentul exista deja!';
            }
         } 
}


        
        if (isset($_POST['actualizeaza'])) {
                $id = $_SESSION['id'];
                //$denumire = $_POST['denumire'];
                $descriere = $_POST['descriere'];
                $bucati = $_POST['bucati'];
                $specie_destinata = $_POST['specie_destinata'];
                
                baza::query('UPDATE petvet.medicamente SET descriere=:descriere, bucati=:bucati, specie_destinata=:specie_destinata WHERE id=:iduser', array(':descriere'=>$descriere, ':bucati'=>$bucati, ':specie_destinata'=>$specie_destinata, ':iduser'=>$id));  
                $err =  "Success!";
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
        <th>Denumire</th>
        <th>Descriere</th>
        <th>Bucati</th>
        <th>Specie Destinata</th>
        <th>UPDATE</th>
        <th>DELETE</th>
      </tr>
      <?php
    
        $medicamente = baza::query('SELECT * FROM petvet.medicamente', array());
        foreach ($medicamente as $medicament) {
            $id = $medicament['id'];
            echo "<tr>";
            echo "<td>".$medicament['id']."</td>";
            echo "<td>".$medicament['denumire']."</td>";
            echo "<td>".$medicament['descriere']."</td>";
            echo "<td>".$medicament['bucati']."</td>";
            echo "<td>".$medicament['specie_destinata']."</td>";
            echo "<td>"."
            <form action="."admin_medicamente.php?id=".$medicament['id']." method="."post".">
                <input type = "."submit"." name="."update"." value="."UPDATE"." >
            </form>
            "."</td>";
            echo "<td>"."
            <form action="."admin_medicamente.php?id=".$medicament['id']." method="."post".">
                <input type = "."submit"." name="."delete"." value="."DELETE"." >
            </form>
            </td></tr>";
        }
        ?>
</table>
    <br> 
	<br>
    <div id = "divreg">
        <center>   
        <form action="admin_medicamente.php" method="post">
        <b><label for="denumire">Denumire</label><br>
        <input type="text" name="denumire" value="" placeholder="Denumire ..."><p />
        <label for="descriere">Descriere</label><br>   
        <textarea name="descriere" value="" placeholder="Descriere ..." rows="5" cols="50"></textarea>
            <p />
        <label for="bucati">Bucati</label><br>
        <input type="number" name="bucati" value="" placeholder="Bucati..."><p />
        <label for="specie_destinata">Specie Destinata</label><br>
        <input type="text" name="specie_destinata" value="" placeholder="Specie Destinata ..."><p />
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
            $denumire = baza::query('SELECT denumire FROM petvet.medicamente WHERE id=:iduser', array(':iduser'=>$id))[0]['denumire'];
            $descriere = baza::query('SELECT descriere FROM petvet.medicamente WHERE id=:iduser', array(':iduser'=>$id))[0]['descriere'];
            $bucati = baza::query('SELECT bucati FROM petvet.medicamente WHERE id=:iduser', array(':iduser'=>$id))[0]['bucati'];
            $specie_destinata = baza::query('SELECT specie_destinata FROM petvet.medicamente WHERE id=:iduser', array(':iduser'=>$id))[0]['specie_destinata'];
            echo "
            <div id = "."divmaintain".">
            <center>   
            <form action="."admin_medicamente.php?id=".$medicament['id']." method="."post".">
            <b><!--<label for="."denumire".">Denumire</label><br>
            <input type="."text"." name="."denumire"." value=".$denumire." placeholder="."Denumire ..."."><p />-->
            <label for="."descriere".">Descriere</label><br>   
            <textarea name="."descriere"." value=".$descriere." placeholder="."Descriere ..."." rows="."5"." cols="."50".">".$descriere."</textarea><p />
            <label for="."bucati".">Bucati</label><br>
            <input type="."number"." name="."bucati"." value=".$bucati." placeholder="."Pret..."."><p />
            <label for="."specie_destinata".">Specie Destinata</label><br>
            <input type="."text"." name="."specie_destinata"." value=".$specie_destinata." placeholder="."Specie Destinata ..."."><p />
            </b>
            ".$err."<br>
            <input type="."submit"." name="."actualizeaza"." value="."UPDATE"." >
            </form>
            </center>
        </div>
            ";
        }
            
         if (isset($_POST['delete'])) {
               baza::query('UPDATE petvet.fisa_medicala SET id_medicament = "" WHERE id_medicament=:id', array(':id'=>$id));
               baza::query('DELETE FROM petvet.medicamente WHERE id=:userid', array(':userid'=>$id));
               header('location: admin_medicamente.php');
        }
        }
        ?>
    
    </body>
</html>