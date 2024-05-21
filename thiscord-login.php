<?php 

$is_invalid = false; //login är valid till att login lyckas

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php"; //link till databas
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {

        if (password_verify($_POST["password"], $user["password_hash"])){ //verifigerar password

            session_start(); //startar ny session

            session_regenerate_id(); // återskapar session id

            $_SESSION["user_id"] = $user["id"];

            header("Location: thiscord-index.php");
            exit;

        }  //kollar om passwprd matchar genom att använda password verify
        
    }

    $is_invalid = true; //om login inte lyckas blir login invalid
}

?>

<html>


<title>Login</title>
<meta charset="UTF-8"> 
<link rel="stylesheet" type="text/css" href="thiscord-login.css">



<body>
<h1 id ="login-h1-logo-txt"><img id ="login-h1-logo" src="103-1031624_discord-logo-thinking-hd-png-download.png"> ThisCord</h1>
<h1>Login</h1>




<form method="post">
    <label for="email"></label>
    <input placeholder="Email" type="email" name="email" id="email"
           value="<?= htmlspecialchars($_POST["email"] ?? "" ) ?>"> <!-- sparar email om login ite lyckas-->
    <label for="password"></label>
    <input placeholder="Password" type="password" name="password" id="password">

    <?php if ($is_invalid):?>
    <em id="invalid-login">Invalid login</em> <!-- om är login är invalid sisas detta medelande-->
    <?php endif; ?>


    <br>
    <br>

    <button id="LogIn-button">log in</button>
</form>

</body>

</html>