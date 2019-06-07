<!DOCTYPE html>
<?php
    require_once("../configuration.php");
    $_pdo = getPDO("injectionJs");
?>
<html>
    <head>
        <title>Injection JS</title>
		<link rel="stylesheet" type="text/css" href="injection_js.css">
    </head>
    <body>
        <h1>Write me some messages...</h1>
		<div class="messages"><ul>
        <?php
            if (isset($_GET["message"])) {
                $req = $_pdo->prepare("INSERT INTO message(text) VALUES (:text);");
                $req -> bindParam(":text", $_GET["message"], PDO::PARAM_STR);
                $req->execute();
                $req->closeCursor();
            }
            $req = $_pdo->prepare("SELECT * FROM message;");
            $req->execute();
            $results = $req->fetchAll();
            $req->closeCursor();

            foreach ($results as $r) {
                if (isset($_GET["enableSecurity"])) {
                    echo "<li class='message'>Message: ".htmlspecialchars($r[1], ENT_QUOTES)."</li>";
                } else {
                    echo "<li class='message'>Message: ".$r[1]."</li>";
                }
            }
        ?>
		</ul></div>
		<div class="redaction">
        <form action="" method="get">
            <h6>Redigez votre message : </h6>
            <textarea name='message' maxlength='5000' placeholder='Contenu du message'></textarea><br/>
            <input type="checkbox" name="enableSecurity" />Enable security<br/>
            <input type="submit" value="Submit" name="submit" />
        </form>
		</div>
    </body>
</html>