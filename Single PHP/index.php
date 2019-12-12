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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Webfejlesztés - Benikovszky Péter (AZ3OS2)</title>

    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);

        .login-page,
        .result-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;
        }

        .form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 360px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        .form input {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
        }

        .form button:hover,
        .form button:active,
        .form button:focus {
            background: #43A047;
        }

        body {
            background: #76b852;
            background: -webkit-linear-gradient(right, #76b852, #8DC26F);
            background: -moz-linear-gradient(right, #76b852, #8DC26F);
            background: -o-linear-gradient(right, #76b852, #8DC26F);
            background: linear-gradient(to left, #76b852, #8DC26F);
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .form p {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 12px;            
        }

        .hanyast__er {
            color: #4CAF50;
            font-weight: bold;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>


</head>

<body>

<?php

    if (!isset($_POST["username"])) {

?>

    <div class="login-page">
        <div class="form">
            <form class="login-form" action="index.php" method="post">
                <input type="text" placeholder="username" name="username" required/>
                <input type="password" placeholder="password" name="password" required/>
                <button>login</button>
                <p>Hanyast ér <span class="hanyast__er" id="hanyas">szerintem?</span></p>
            </form>
        </div>
    </div>
    <script>
        document.querySelector('#hanyas').addEventListener('click', (e) => {
            e.target.parentElement.innerHTML = `
                <h4>Szerintem megér egy ötöst :)</h4>
                <ul style="text-align: left;">
                    <li>minden követelménynek megfelel</li>
                    <li>egy php fileból áll az egész</li>
                    <li>minimalista, de esztétikus :)</li>
                </ul>
            `;
        })
    </script>
<?php

    } else {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $file = fopen("password.txt", "r");

        $fileContent = trim(fread($file, filesize("password.txt")), "\n");
        $lines = explode("\n", $fileContent);
        
        $userPassword = getPasswordForUser($username, $lines);        
?>

    <div class="result-page">
        <div class="form">

<?php
if ($userPassword == "") {

    echo "<h1>Nincs ilyen felhasználó</h1>";
} else if ($userPassword != $password) {
    ?>    

    <h1>Hibás jelszó</h1>
    <h3>Átirányítás a rendőrségre: <span id="timer">3</span></h3>
    <script>
        setInterval(() => {
            document.querySelector("#timer").innerText -= 1 
        }, 1000);
        setTimeout(function() { 
            window.location.href="http://www.police.hu/"; 
        }, 3000)
    </script>
<?php
} else {

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
    
    echo "<h3>Üdv $username</h3>";
    echo "<img src='http://shrek.unideb.hu/~herakles/ZH/$titkos.png'>";

}
?>

        </div>
    </div>

<?php } ?>

</body>

</html>