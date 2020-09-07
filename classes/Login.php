<?php
class Login {
        public static function isLoggedIn() {
                if (isset($_COOKIE['PVID'])) {
                    if (baza::query('SELECT user_id FROM petvet.login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['PVID'])))) {
                        $userid = baza::query('SELECT user_id FROM petvet.login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['PVID'])))[0]['user_id'];
                        if (isset($_COOKIE['PVID_'])) {
                                return $userid;
                        } else {
                                $cstrong = True;
                                $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                                baza::query('INSERT INTO petvet.login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$userid));
                                baza::query('DELETE FROM petvet.login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['PVID'])));
                                setcookie("PVID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                                setcookie("PVID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                                return $userid;
                        }
                }
                }
                return false;
        }
}
?>