<?php
include('./classes/baza.php');
include('./classes/Login.php');
if (Login::isLoggedIn()) {
        echo 'Logged In';
        echo Login::isLoggedIn();
        header('location: homepage.php');
} else {
        echo 'Not logged in';
        header('location: index_logout.php');
}
?>