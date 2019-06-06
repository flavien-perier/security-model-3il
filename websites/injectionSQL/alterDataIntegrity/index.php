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
            <p class="instructions">Find an article</p>
            <input type="text" name="search" /><br />
            <input type="checkbox" name="enableSecurity" /><span class="text_checkbox">Enable security</span><br>
            <input type="submit" value="Find" name="submit" />
        </form>

        <ul>
            <?php
                $search = "%";
                if (isset($_POST["search"]) && $_POST["search"] != "") {
                    $search = $_POST["search"];
                }

                $req;
                if (isset($_POST["enableSecurity"])) {
                    $req = $_pdo->prepare("SELECT * FROM item WHERE label LIKE :search");
                    $req -> bindParam(":search", $search, PDO::PARAM_STR);
                } else {
                    $req = $_pdo->prepare("SELECT * FROM item WHERE label LIKE '".$search."'");
                }
                $req->execute();
                $results = $req->fetchAll();
                $req->closeCursor();

                foreach ($results as $r) {
                    echo "<li> Object : ".$r[1]." | Price : ".$r[2]."</li>";
                }
            ?>
        </ul>
    </body>
</html>