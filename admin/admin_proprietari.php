<?php
include('../classes/baza.php');
session_start();
$err = "";
if (isset($_POST['insert'])) {
        $nume = $_POST['nume'];
        $prenume = $_POST['prenume'];
        $cnp = $_POST['cnp'];
    
        if($nume == "" || $prenume == "" || $cnp == "" ) {
             $err = 'Completati toate campurile!'; 
        } else {
            if (!baza::query('SELECT cnp FROM petvet.proprietari WHERE cnp=:cnp', array(':cnp'=>$cnp))) {
            
                baza::query('INSERT INTO petvet.proprietari VALUES (\'\', :nume, :prenume, :cnp)', array(':nume'=>$nume, ':prenume'=>$prenume, ':cnp'=>$cnp));
                $err =  "Success!";
                    
             } else {
                    $err = 'Proprietarul exista deja!';
            }
         } 
}


        
        if (isset($_POST['actualizeaza'])) {
                $id = $_SESSION['id'];
                $nume = $_POST['nume'];
                $prenume = $_POST['prenume'];
                $cnp = $_POST['cnp'];

                baza::query('UPDATE petvet.proprietari SET nume=:nume, prenume=:prenume, cnp=:cnp WHERE id=:iduser', array(':nume'=>$nume, ':prenume'=>$prenume, ':cnp'=>$cnp, ':iduser'=>$id));  
                $err =  "Success!";
        }
        if (isset($_POST['delete'])){
            header('location: admin_proprietari.php');
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
        <th>Prenume</th>
        <th>CNP</th>
        <th>UPDATE</th>
        <th>DELETE</th>
      </tr>
      <?php
    
        $proprietari = baza::query('SELECT * FROM petvet.proprietari', array());
        foreach ($proprietari as $proprietar) {
            $id = $proprietar['id'];
            echo "<tr>";
            echo "<td>".$proprietar['id']."</td>";
            echo "<td>".$proprietar['nume']."</td>";
            echo "<td>".$proprietar['prenume']."</td>";
            echo "<td>".$proprietar['cnp']."</td>";
            echo "<td>"."
            <form action="."admin_proprietari.php?id=".$proprietar['id']." method="."post".">
                <input type = "."submit"." name="."update"." value="."UPDATE"." >
            </form>
            "."</td>";
            echo "<td>"."
            <form action="."admin_proprietari.php?id=".$proprietar['id']." method="."post".">
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
        <form action="admin_proprietari.php" method="post">
        <b><label for="nume">Nume</label><br>
        <input type="text" name="nume" value="" placeholder="Nume ..."><p />
        <label for="prenume">Prenume</label><br>   
        <input type="text" name="prenume" value="" placeholder="Prenume ..."><p />
        <label for="cnp">CNP</label><br>
        <input type="text" name="cnp" value="" placeholder="CNP..."><p />
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
            $nume = baza::query('SELECT nume FROM petvet.proprietari WHERE id=:iduser', array(':iduser'=>$id))[0]['nume'];
            $prenume = baza::query('SELECT prenume FROM petvet.proprietari WHERE id=:iduser', array(':iduser'=>$id))[0]['prenume'];
            $cnp = baza::query('SELECT cnp FROM petvet.proprietari WHERE id=:iduser', array(':iduser'=>$id))[0]['cnp'];
            echo "
            <div id = "."divmaintain".">
            <center>   
            <form action="."admin_proprietari.php?id=".$proprietar['id']." method="."post".">
            <b><label for="."nume".">Nume</label><br>
            <input type="."text"." name="."nume"." value=".$nume." placeholder="."Nume ..."."><p />
            <label for="."prenume".">Prenume</label><br>   
            <input type="."text"." name="."prenume"." value=".$prenume." placeholder="."Prenume ..."."><p />
            <label for="."cnp".">CNP</label><br>
            <input type="."text"." name="."cnp"." value=".$cnp." placeholder="."CNP..."."><p />
            </b>
            ".$err."<br>
            <input type="."submit"." name="."actualizeaza"." value="."UPDATE"." >
            </form>
            </center>
        </div>
            ";
        }
            
         if (isset($_POST['delete'])) {
             
               baza::query('UPDATE petvet.pacienti SET id_proprietar = null WHERE id_proprietar=:iduser', array(':iduser'=>$id));
               baza::query('DELETE FROM petvet.proprietari WHERE id=:userid', array(':userid'=>$id));
               header('location: admin_proprietari.php');
        }
        }
        ?>
    
    </body>
</html>