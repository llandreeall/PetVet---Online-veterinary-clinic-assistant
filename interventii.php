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

if (isset($_POST['inapoi'])){
    header('location: inventar.php');
}
?>
<html>
<head>
    <title>PetVet</title>
	<link rel = "stylesheet" type="text/css" href = "css/stil_login.css"> 
	<style type="text/css">
		#div1 {
				width: 1250px;
				height: 100%;
				margin-left: 50px;
				margin-right: 50px;
				background-color: rgba(255, 255, 255, 1);
				
			}
		
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
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
		    <font color="#ecf0f1">	Acestea sunt toate Interventiile
			</font>
	    </span>
     </nav>
	<br> 
	<br>
    <div id = "div1">
        <table>
      <tr>
        <th>Denumire</th>
        <th>Descriere</th>
        <th>Pret</th>
        <th> <form action="interventii.php" method="post">
				<input type="submit" name="inapoi" value="Inapoi" class="button">
			</form></th>
      </tr>
      <?php
    
        $interventii = baza::query('SELECT * FROM petvet.interventii', array());
        foreach ($interventii as $interventie) {
            echo "<tr>";
            echo "<td>".$interventie['denumire']."</td>";
            echo "<td>".$interventie['descriere']."</td>";
            echo "<td>".$interventie['pret']."</td>";
            echo "</tr>";
        }
        ?>
</table>
    </div>
    </body>
</html>