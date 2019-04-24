<?php
session_start();

function startBody($EHA) {
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"hu\" xml:lang=\"hu\">\n";
    echo "<head>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
    echo "<meta http-equiv=\"Content-Language\" content=\"hu\">\n";
    echo "<title>Információbiztonság gyakorló feladat (".htmlspecialchars($EHA).")</title>\n";
    echo "</head>\n";
    echo "<body>\n";
}

function userHead($NAME, $EHA) {
    echo "Bejelentkezve: ".htmlspecialchars($NAME)." (".htmlspecialchars($EHA).") <a href=\"logout.php\">Logout</a>\n";
    echo "<hr/>\n";
}

function loginForm($EHA = '') {
    echo "<form action=\"feladat.php\" method=\"post\">\n";
    echo "<table>\n";
    echo "<tr><td>EHA:</td><td><input name=\"login\" type=\"text\" value=\"".htmlspecialchars($EHA, ENT_COMPAT)."\" width=\"40\"/></td></tr>\n";
    echo "<tr><td>Password:</td><td><input name=\"password\" type=\"password\" width=\"40\"/></td></tr>\n";
    echo "<tr><td></td><td><input type=\"submit\" value=\"Login\"/></td></tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}

function sendMessageForm() {
    echo "<form action=\"feladat.php\" method=\"post\">\n";
    echo "<table>\n";
    echo "<tr><td>Deadline:</td><td><input name=\"deadline\" type=\"text\" width=\"20\"/></td></tr>\n";
    echo "<tr><td>Task:</td><td><input name=\"task\" type=\"text\" width=\"80\"/></td></tr>\n";
    echo "<tr><td></td><td><input type=\"submit\" value=\"Add\"/></td></tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}

function filterMessageForm($FILT) {
    echo "<form action=\"feladat.php\" method=\"post\">\n";
    echo "<table>\n";
    echo "<tr><td>Date:</td><td><input name=\"date\" type=\"text\" value=\"".htmlspecialchars($FILT, ENT_COMPAT)."\" width=\"20\" readonly /></td></tr>\n";
    echo "<tr><td></td><td><input type=\"submit\" value=\"Filter\"/></td></tr>\n";
    echo "</table>\n";
    echo "</form>\n";
}

function endBody() {
    echo "</body>\n";
}

if(empty($_SESSION['userid'])) {
if(!isset($_POST['login'])) {
        startBody("---");
        loginForm();
        endBody();
    } else{
        $var = $_POST['login'];
        list($dbfile) = explode('.', basename($var, '.SZE'));
        $dbfile = '/var/www/html/gyakorlo/gy04/'.strtoupper($dbfile).'.db';
      if (file_exists($dbfile)) {
        if(!empty($_POST['password'])) {
            $db = new SQLite3($dbfile);
            $rs = $db->query("SELECT id, name FROM users WHERE id = '".$_POST['login']."' AND pwd = '".md5($_POST['password'])."'");
            if($row = $rs->fetchArray()) {
                $_SESSION["userid"]   = $row['id'];
                $_SESSION["username"] = $row['name'];
                header('Location: feladat.php');
            } else {
                startBody('---');
                echo "<b>A jelszó nem egyezik a(z) <tt>".$_POST['login']."</tt> felhasználó adatbázisában tárolt jelszóval.</b>\n<hr/>\n";
                loginForm($_POST['login']);
                endBody();
            }
         }
         else {
                startBody('---');
                echo "<b>Hiányzó jelszó (<tt>".$_POST['login']."</tt>).</b>\n<hr/>\n";
                loginForm();
                endBody();
        }
        }
     else {
        startBody("---");
        echo "<b>Nem található adatbázis a(z) <tt>".htmlspecialchars($_POST['login'])."</tt> felhasználóhoz.</b>\n<hr/>\n";
        loginForm();
        endBody();
    }
    
}
exit;
}
else{
$var = $_SESSION["userid"];
list($dbfile) = explode('.', basename($var, '.SZE'));
$dbfile = '/var/www/html/gyakorlo/gy04/'.strtoupper($dbfile).'.db';
$db = new SQLite3($dbfile);

startBody($_SESSION['userid']);
userHead($_SESSION['username'], $_SESSION['userid']);

if(!empty($_POST['deadline']) && !empty($_POST['task'])) {
    $db->exec("INSERT INTO tasks(dl, tk) VALUES ('".
        SQLite3::escapeString($_POST['deadline'])."', '".
        SQLite3::escapeString($_POST['task'])."')");
}

if(!isset($_SESSION['filter'])) {
    $_SESSION['filter'] = date('Y-m-d H:i:s');
}

if(isset($_POST['date'])) {
    $_SESSION['filter'] = $_POST['date'];
}

filterMessageForm($_SESSION['filter']);

echo "<table>\n";
$i  = 1;
$w  = '';
if(!empty($_SESSION['filter'])) {
    $w = " WHERE dl > '".$_SESSION['filter']."'";
}
$rs = $db->query("SELECT * FROM tasks".$w." ORDER BY dl");
echo "<tr><td></td><td>&nbsp;</td><td><b>deadline</b></td><td>&nbsp;</td><td><b>task</b></td></tr>\n";
while($row = $rs->fetchArray()) {
    echo "<tr><td>#".$i++.":</td><td>&nbsp;</td><td>".
        htmlspecialchars($row['dl'])."</td><td>&nbsp;</td><td>".
        htmlspecialchars($row['tk'])."</td></tr>\n";
}
echo "</table>\n<hr/>\n";

sendMessageForm();

echo "<hr/>\nA következő feladat meghatározni, hogy mi volt a <tt>SECRET</tt> és <tt>MESSAGE</tt> makrók értéke,".
     " amikor <a href=\"prog.c\">ebből a forrásból</a> <a href=\"prog\">ezt a binárist</a> fordítottunk.";

endBody();

}
?>
