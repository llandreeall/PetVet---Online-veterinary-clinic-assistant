<?php
include('../classes/baza.php');
session_start();
$err = "";
if (isset($_POST['insert'])) {
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
                    $err =  "Success!";
                    } else {
                        $err = 'CNP-ul exista deja!';
                }
             } else {
                    $err = 'Utilizatorul exista deja!';
            }
         } 
}


        
        if (isset($_POST['actualizeaza'])) {
                $id = $_SESSION['id'];
                $nume = $_POST['nume'];
                $prenume = $_POST['prenume'];
                $cnp = $_POST['cnp'];
                $username = $_POST['username'];
                $parola = $_POST['parola'];
                $specializare = $_POST['specializare'];

                if($parola) {
                baza::query('UPDATE petvet.medici SET parola=:newpassword WHERE id=:iduser', array(':newpassword'=>password_hash($parola, PASSWORD_BCRYPT), ':iduser'=>$id));  }

                baza::query('UPDATE petvet.medici SET nume=:nume, prenume=:prenume, cnp=:cnp, username=:username, specializare=:specializare WHERE id=:iduser', array(':nume'=>$nume, ':prenume'=>$prenume, ':cnp'=>$cnp, ':username'=>$username, ':specializare'=>$specializare, ':iduser'=>$id));  
                $err =  "Success!";
        }
        
        if (isset($_POST['delete'])){
            header('location: admin_medici.php');
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
        <th>Username</th>
        <th>Specializare</th>
        <th>UPDATE</th>
        <th>DELETE</th>
      </tr>
      <?php
    
        $medici = baza::query('SELECT * FROM petvet.medici', array());
        foreach ($medici as $medic) {
            $id = $medic['id'];
            echo "<tr>";
            echo "<td>".$medic['id']."</td>";
            echo "<td>".$medic['nume']."</td>";
            echo "<td>".$medic['prenume']."</td>";
            echo "<td>".$medic['cnp']."</td>";
            echo "<td>".$medic['username']."</td>";
            echo "<td>".$medic['specializare']."</td>";
            echo "<td>"."
            <form action="."admin_medici.php?id=".$medic['id']." method="."post".">
                <input type = "."submit"." name="."update"." value="."UPDATE"." >
            </form>
            "."</td>";
            echo "<td>"."
            <form action="."admin_medici.php?id=".$medic['id']." method="."post".">
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
        <form action="admin_medici.php" method="post">
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
        <input type="submit" name="insert" value="INSERT" >
        </form>
        </center>
    </div>
    <?php
        if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (isset($_POST['update'])) {
            $_SESSION['id'] = $id;
            $username = baza::query('SELECT username FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$id))[0]['username'];
            $nume = baza::query('SELECT nume FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$id))[0]['nume'];
            $prenume = baza::query('SELECT prenume FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$id))[0]['prenume'];
            $cnp = baza::query('SELECT cnp FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$id))[0]['cnp'];
            $specializare = baza::query('SELECT specializare FROM petvet.medici WHERE id=:iduser', array(':iduser'=>$id))[0]['specializare'];
            echo "
            <div id = "."divmaintain".">
            <center>   
            <form action="."admin_medici.php?id=".$medic['id']." method="."post".">
            <b><label for="."nume".">Nume</label><br>
            <input type="."text"." name="."nume"." value=".$nume." placeholder="."Nume ..."."><p />
            <label for="."prenume".">Prenume</label><br>   
            <input type="."text"." name="."prenume"." value=".$prenume." placeholder="."Prenume ..."."><p />
            <label for="."cnp".">CNP</label><br>
            <input type="."text"." name="."cnp"." value=".$cnp." placeholder="."CNP..."."><p />
            <label for="."username".">Username</label><br>
            <input type="."text"." name="."username"." value=".$username." placeholder="."Username ..."."><p />
            <label for="."parola".">Parola</label><br>
            <input type="."password"." name="."parola"."  placeholder="."Parola ..."."><p />
            <label for="."specializare".">Specializare</label><br>
            <input type="."text"." name="."specializare"." value=".$specializare." placeholder="."Specializare..."."><p /></b>
            ".$err."<br>
            <input type="."submit"." name="."actualizeaza"." value="."UPDATE"." >
            </form>
            </center>
        </div>
            ";
        }
            
         if (isset($_POST['delete'])) {
               baza::query('DELETE FROM petvet.login_tokens WHERE user_id=:userid', array(':userid'=>$id));
               baza::query('DELETE FROM petvet.medici_interventii WHERE id_medic=:userid', array(':userid'=>$id));
               baza::query('DELETE FROM petvet.medici WHERE id=:userid', array(':userid'=>$id));
               header('location: admin_medici.php');
        }
        }
        ?>
    
    </body>
</html>