# File Upload

## Explication de la faille

Il est possible sur certains sites internet d'uploader des fichiers. Dans la plupart des cas, il s'agit d'images, cependant les formulaires n'effectuent pas toujours de vérifications quant au type de fichier envoyé par l'utilisateur. Dans ce cas nous avons la possibilité d'uploader n'importe quel type de fichier.
Dans notre cas nous uploadons un fichier PHP utilisant une autre faille offrant la possibilité d'exécuter des commandes directement sur le serveur. Ainsi qu'un fichier java ayant pour but de chiffrer un dossier.

Dans notre cas nous allons exécuter le cryptolocker que nous avons uploadé.

`java -jar C:\Users\Administrateur\Desktop\securityModel3IL\websites\fileUpload\files\cryptolocker.jar`

## Explication du correctif

Pour corriger ce problème, il suffit de vérifier l'extension du fichier. En effet le serveur s’il est bien configuré ne sera pas en mesure d'exécuter un code PHP si son conteneur ne finit pas par l'extension adéquate.
