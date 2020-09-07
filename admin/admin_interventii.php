<?php
include('../classes/baza.php');
session_start();
$err = "";
if (isset($_POST['insert'])) {
        $denumire = $_POST['denumire'];
        $descriere = $_POST['descriere'];
        $pret = $_POST['pret'];
    
        if($denumire == "" || $descriere == "" || $pret == "" ) {
             $err = 'Completati toate campurile!'; 
        } else {
            if (!baza::query('SELECT denumire FROM petvet.interventii WHERE denumire=:denumire', array(':denumire'=>$denumire))) {
            
                baza::query('INSERT INTO petvet.interventii VALUES (\'\', :denumire, :descriere, :pret)', array(':denumire'=>$denumire, ':descriere'=>$descriere, ':pret'=>$pret));
                $err =  "Success!";
                    
             } else {
                    $err = 'Interventia exista deja!';
            }
         } 
}


        
        if (isset($_POST['actualizeaza'])) {
                $id = $_SESSION['id'];
                $denumire = $_POST['denumire'];
                $descriere = $_POST['descriere'];
                $pret = $_POST['pret'];
                
                baza::query('UPDATE petvet.interventii SET descriere=:descriere, pret=:pret WHERE id=:iduser', array(':descriere'=>$descriere, ':pret'=>$pret, ':iduser'=>$id));  
                $err =  "Success!";
        }
    if (isset($_POST['delete'])){
        header('location: admin_interventii.php');
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
        <th>Pret</th>
        <th>UPDATE</th>
        <th>DELETE</th>
      </tr>
      <?php
    
        $interventii = baza::query('SELECT * FROM petvet.interventii', array());
        foreach ($interventii as $interventie) {
            $id = $interventie['id'];
            echo "<tr>";
            echo "<td>".$interventie['id']."</td>";
            echo "<td>".$interventie['denumire']."</td>";
            echo "<td>".$interventie['descriere']."</td>";
            echo "<td>".$interventie['pret']."</td>";
            echo "<td>"."
            <form action="."admin_interventii.php?id=".$interventie['id']." method="."post".">
                <input type = "."submit"." name="."update"." value="."UPDATE"." >
            </form>
            "."</td>";
            echo "<td>"."
            <form action="."admin_interventii.php?id=".$interventie['id']." method="."post".">
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
        <form action="admin_interventii.php" method="post">
        <b><label for="denumire">Denumire</label><br>
        <input type="text" name="denumire" value="" placeholder="Denumire ..."><p />
        <label for="descriere">Descriere</label><br>   
        <textarea name="descriere" value="" placeholder="Descriere ..." rows="5" cols="50"></textarea>
            <p />
        <label for="pret">Pret</label><br>
        <input type="number" name="pret" value="" placeholder="Pret..."><p />
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
            $denumire = baza::query('SELECT denumire FROM petvet.interventii WHERE id=:iduser', array(':iduser'=>$id))[0]['denumire'];
            $descriere = baza::query('SELECT descriere FROM petvet.interventii WHERE id=:iduser', array(':iduser'=>$id))[0]['descriere'];
            $pret = baza::query('SELECT pret FROM petvet.interventii WHERE id=:iduser', array(':iduser'=>$id))[0]['pret'];
            echo "
            <div id = "."divmaintain".">
            <center>   
            <form action="."admin_interventii.php?id=".$interventie['id']." method="."post".">
            <b><label for="."denumire".">Denumire</label><br>
            <input type="."text"." name="."denumire"." value=".$denumire." placeholder="."Denumire ..."."><p />
            <label for="."descriere".">Descriere</label><br>   
            <textarea name="."descriere"." value=".$descriere." placeholder="."Descriere ..."." rows="."5"." cols="."50".">".$descriere."</textarea><p />
            <label for="."pret".">Pret</label><br>
            <input type="."number"." name="."pret"." value=".$pret." placeholder="."Pret..."."><p />
            </b>
            ".$err."<br>
            <input type="."submit"." name="."actualizeaza"." value="."UPDATE"." >
            </form>
            </center>
        </div>
            ";
        }
            
         if (isset($_POST['delete'])) {
               if (baza::query('SELECT id_interventie FROM petvet.medici_interventii WHERE id_interventie=:userid', array(':userid'=>$id))){
                    baza::query('DELETE FROM petvet.medici_interventii WHERE id_interventie=:userid', array(':userid'=>$id));
               }
               baza::query('UPDATE petvet.fisa_medicala SET id_interventie = "" WHERE id_interventie=:id', array(':id'=>$id));
               baza::query('DELETE FROM petvet.interventii WHERE id=:userid', array(':userid'=>$id));
               header('location: admin_interventii.php');
        }
        }
        ?>
    
    </body>
</html>