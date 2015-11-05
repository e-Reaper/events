<?php
class User {
public $email;
public $name;
public $isLoggedIn = false;
function __construct() {
if (session_id() == "") {
session_start();
}
if (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']== true) {
$this->_initUser();
}
} //end __construct
public function authenticate($user,$pass) {
if (session_id() == "") {
session_start();
}
$_SESSION['isLoggedIn'] = false;
$this->isLoggedIn = false;
$mysqli = new mysqli(DBHOST,DBUSER,DBPASS,DB);
if ($mysqli->connect_errno) {
error_log("Cannot connect to MySQL: " .
$mysqli->connect_error);
return false;
}
$safeUser = $mysqli->real_escape_string($user);
$incomingPassword = $mysqli->real_escape_string($pass);
$query = "SELECT email,password,name from users WHERE email ='{$safeUser}'";
if (!$result = $mysqli->query($query)) {
error_log("Cannot retrieve account for {$user}");
return false;
}
// Will be only one row, so no while() loop needed
$row1 = $result->fetch_assoc();
$dbPassword = $row1['password'];
$name=$row1['name'];
if (crypt($incomingPassword,$dbPassword) !=$dbPassword) {
error_log("Passwords for {$user} don't match");
return false;
}

$this->email = $safeUser;
$this->name = $name;
$this->isLoggedIn = true;
$this->_setSession();
return true;
} //end function authenticate
private function _setSession() {
if (session_id() == '') {
session_start();
}
$_SESSION['email']=$this->email;
$_SESSION['isLoggedIn'] =$this->isLoggedIn;
$_SESSION['name'] =$this->name;

} //end function setSession
private function _initUser() {
if (session_id() == '') {
session_start();
}

$this->email = $_SESSION['email'];
$this->isLoggedIn = $_SESSION['isLoggedIn'];
} //end function initUser
public function logout() {
$this->isLoggedIn = false;
if (session_id() == '') {
session_start();
}
$_SESSION['isLoggedIn'] = false;
foreach ($_SESSION as $key => $value) {
$_SESSION[$key] = "";
unset($_SESSION[$key]);
}
$_SESSION = array();
if (ini_get("session.use_cookies")) {
$cookieParameters = session_get_cookie_params();
setcookie(session_name(), '', time() - 28800,$cookieParameters['path'],$cookieParameters['domain'],$cookieParameters['secure'],$cookieParameters['httponly']);
} //end if
session_destroy();
} //end function logout
} //end class User