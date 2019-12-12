<?php

function getPasswordForUser($username, $encodedLines)
{

    $codeArray = array(5, -14, 31, -9, 3);
    $found = false;
    $currentEncodedLine = 0;

    while (!$found && $currentEncodedLine < count($encodedLines)) {
        
        $encodedLine = $encodedLines[$currentEncodedLine++];
        $decodedLine = "";

        for ($i = 0; $i < strlen($encodedLine); $i++) {
            $decodedLine .= chr(ord($encodedLine[$i]) - $codeArray[$i % 5]);
        }

        $userData = explode("*", $decodedLine);
        if ($userData[0] == $username) {
            $found = true;
        }
            
    }

    return $found ? trim($userData[1]) : "";

}

$username = $_POST["username"];
$password = $_POST["password"];

$file = fopen("password.txt", "r");

$fileContent = trim(fread($file, filesize("password.txt")), "\n");
$lines = explode("\n", $fileContent);

$userPassword = getPasswordForUser($username, $lines);

if ($userPassword == "") {

    echo "<style>"; 
    
        echo "body {";
            echo "text-align: center;";
        echo "}";

        echo "h1 {";
            echo "text-transform: uppercase;";
            echo "font-family: 'Consolas', Arial, sans-serif;";
        echo "}";

        echo "img {";
            echo "width: 200px;";
        echo "}";
        

    echo "</style>";    

    echo "<h1>Nincs ilyen felhasználó</h1>";
    echo "<img src='sad.png' alt='sad face'>";
    exit;
}

if ($userPassword != $password) {

    echo "<style>"; 
    
        echo "body {";
            echo "width: 100vw;";
            echo "height: 100vh;";
            echo "background-color: red;";
            echo "color: white;";
            echo "display: flex;";
            echo "display: -webkit-box;";
            echo "display: -ms-flex;";
            echo "justify-content: center;";
            echo "-webkit-box-pack: center;";
            echo "-ms-flex-pack: center;";
            echo "align-items: center;";
            echo "-webkit-box-align: center;";
            echo "-ms-flex-align: center;";
        echo "}";

        echo "h1 {";
            echo "text-transform: uppercase;";
            echo "font-family: 'Consolas', Arial, sans-serif;";
        echo "}";

    echo "</style>";

    echo "<h1>Hibás jelszó</h1>";
    echo "<script>";
    echo "setTimeout(function(){ window.location.href=\"http://www.police.hu/\"; }, 3000);";
    echo "</script>";
    exit;
}


$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'adatok';

$dbconn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($dbconn->connect_error) {
    die('Could not connect: ' . $dbconn->connect_error);
}

$sql = "SELECT Titkos FROM tabla WHERE Username='$username' limit 1";
$result = $dbconn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $titkos = $row["Titkos"];

}

mysqli_close($dbconn);

echo "<div style=\"width: 500px; margin: 50px auto; text-align:center;\">";
echo "<h1>Welcome $username</h1>";
echo "<img src=\"http://shrek.unideb.hu/~herakles/ZH/$titkos.png\">";
echo "</div>";
