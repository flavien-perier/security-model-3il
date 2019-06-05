# Directory Exploration

## Explication de la faille

Certains sites permettent d'afficher le contenu de dossiers ainsi que celui de ses sous-dossiers. Cependant il est parfois possible par le biais d'injection de détourner l'affichage et de parcourir l'arborescence complète du système.

## Explication du correctif

Plusieurs correctifs à envisager :
- Développement : vérifier que la chaine saisie par l'utilisateur ne contienne pas de `..`.
- Système : Interdire par le biais de la configuration serveur l'affichage de dossier parent de celui ou se trouve le site web. Sous IIS il est par exemple possible de bloquer `Directory Browsing`.
