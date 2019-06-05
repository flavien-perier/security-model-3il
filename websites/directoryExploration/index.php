<!DOCTYPE html>
<html>
    <head>
        <title>Directory exploration</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
    <body>
        <h1>Directory exploration</h1>
        <div>
            <h2>Files</h2>
            <ul>
            <?php
                $directory = "";
                $fileDirectory = "";
                $attackBlocked = false;
                if (!isset($_GET["directory"]) || !isset($_GET["enableSecurity"])) {
                    header('Location: ./?enableSecurity=false&directory=.'); 
                } else {
                    $directory = $_GET["directory"];
                    if ($_GET["enableSecurity"] == "true" && preg_match("/\.{1,2}/i", $directory)) {
                        $attackBlocked = true;
                        $directory = ".";
                    }
                    $fileDirectory = "./files/".$directory;
                }
                if (is_dir($fileDirectory) && $handle = opendir($fileDirectory)) {
                    if (!$attackBlocked) {
                        while (($file = readdir($handle)) != false) {
                            if ($file != "..") {
                                if (is_dir($fileDirectory."/".$file)) {
                                    echo "<li><a href='?enableSecurity=".$_GET["enableSecurity"]."&directory=$directory/$file'>$file</a></li>";
                                } else {
                                    echo "<li>$file</li>";
                                }
                            }
                        }
                    } else {
                        echo "<li>Attack blocked</li>";
                    }
                    closedir($handle);
                } else {
                    echo "<li>Directory doesn't exist</li>";
                }
            ?>
            </ul>
        </div>
    </body>
</html>