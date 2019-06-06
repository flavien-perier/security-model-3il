<!DOCTYPE html>
<?php
    require_once("../../configuration.php");
    $_pdo = getPDO("injectionSQL");
?>

<html>
    <head>
        <title>SQL Injection</title>
        <link rel="stylesheet" type="text/css" href="../styles.css">
    </head>
    <body>
        <h1>SQL Injection</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <span class="user">Username : </span><input type="text" name="username" /><br />
            <span class="user">Password : <input type="password" name="password" /><br />
            <input type="checkbox" name="enableSecurity" /><span class="text_checkbox">Enable security</span><br/>
            <input type="submit" value="login" name="login" />
        </form>

        <?php
            $search = "%";
            if (isset($_POST["username"]) && $_POST["username"] != "" &&
                isset($_POST["password"]) && $_POST["password"] != "") {
                $req;

                if (isset($_POST["enableSecurity"])) {
                    $req = $_pdo->prepare("SELECT * FROM user WHERE name = :name AND password = md5(:password);");
                    $req -> bindParam(":name", $_POST["username"], PDO::PARAM_STR);
                    $req -> bindParam(":password", $_POST["password"], PDO::PARAM_STR);
                } else {
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $req = $_pdo->prepare("SELECT * FROM user WHERE name = '".$username."' AND password = md5('".$password."');");
                }
                $req->execute();
                $results = $req->fetchAll();
                $req->closeCursor();

                if (sizeof($results) == 0) {
                    echo "<p>Bad auth<p/>";
                } else {
                    echo "<p>Auth ok<p />";
                }
            }
        ?>
    </body>
</html>