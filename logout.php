<?php
include('./classes/baza.php');
include('./classes/Login.php');

if (!Login::isLoggedIn()) {
        die("Not logged in.");
}
//if (isset($_POST['confirm'])) {
       // if (isset($_POST['alldevices'])) {
        baza::query('DELETE FROM petvet.login_tokens WHERE user_id=:userid', array(':userid'=>Login::isLoggedIn()));
        header('location: index.php');
        //} else {
        //        if (isset($_COOKIE['PVID'])) {
        //                baza::query('DELETE FROM petvet.login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['PVID'])));
         //       }
         //       setcookie('PVID', '1', time()-3600);
         //       setcookie('PVID_', '1', time()-3600);
      //  }
//}
?>
<h1>Logout of your Account?</h1>
<p>Are you sure you'd like to logout?</p>
<form action="logout.php" method="post">
        <!--<input type="checkbox" name="alldevices" value="alldevices"> Logout of all devices?<br />-->
        <!--<input type="submit" name="confirm" value="Confirm">-->
</form>