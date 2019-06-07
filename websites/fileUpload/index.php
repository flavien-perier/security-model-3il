<!DOCTYPE html>
<html>
    <head>
        <title>File Upload</title>
		<link rel="stylesheet" type="text/css" href="fileUpload.css">
    </head>
    <body>
        <h1>File Upload</h1>
		<div class="cadre">
        <?php
            if (isset($_POST["submit"]) && isset($_FILES)) {
                $fileDirectory = "files/".basename($_FILES["fileUploaded"]["name"]);
                $imageFileType = strtolower(pathinfo($fileDirectory, PATHINFO_EXTENSION));

                $uploadAccepted = 1;

                if (isset($_POST["enableSecurity"])) {
                    if ($imageFileType != "jpg" && $imageFileType != "png") {
                        echo "Bad file format";
                        $uploadAccepted = 0;
                    }
                }

                if ($uploadAccepted == 1) {
                    if (move_uploaded_file($_FILES["fileUploaded"]["tmp_name"], $fileDirectory)) {
                        echo "Upload OK";
                    } else {
                        echo "Upload error";
                    }
                }

            }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
            <p class="indication">File to upload :</p>
			<label id="fileinput" for="fileUploaded"><label id="lblfu" for="fileUploaded">Select a file...</label>
            <input type="file" name="fileUploaded" id="fileUploaded"/><br/>
            </label>
			<input type="checkbox" name="enableSecurity" />Enable security<br/>
            <input id="upload" type="submit" value="Upload File" name="submit" />
        </form>
		</div>
		<div class="cadre">
            <h2>Files</h2>
            <?php
                if ($handle = opendir("./files")) {
                    while (false !== ($file = readdir($handle))) {
                        if ($file != "." && $file != "..") {
                            echo "<img src='./files/$file' alt='$file' width=100/>";
                        }
                    }
                    closedir($handle);
                }
            ?>
		</div>
    </body>
</html>
<script>
window.onload=function(){
	document.querySelector('input[type=file]').addEventListener("change", function(){
		var t = this.value;
		var labelText = 'File : ' + t.substr(12, t.length);
		document.getElementById("lblfu").innerHTML = labelText;
	});
}
</script>
