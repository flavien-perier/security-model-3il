# Buffer Overflow

## Installation du serveur

- Installer le serveur: `npm install`
- Compile l'exécutable d'authentification: `npm run build`
- Lancer le serveur: `npm start`
- Le serveur ce lance sur le port: `0.0.0.0:8080`

## Explication de la faille

Le principe du débordement de Buffer est de sortir de la zone mémoire qui nous est allouée afin d'écrire dans d'autres champs auquel nous ne devrions pas avoir accès.

Dans notre cas les identifiants ne devraient pas dépasser les 13 caractères... Mais aucune vérification n'est effectuée sur la longueur de la chaine. Nous injectons donc un T dans le champ qui suit... Ce qui aura pour effet de forcer l'état de l'identification à `T` (true pour authentification autorisée)
- username: `admin`
- password: `AAAAAAAAAAAAAAAT`

## Explication du correctif

Normalement l'utilisation de langage moderne est censée suffire pour se protéger de ces failles.
Si le langage ou les librairies utilisés ne sécurisent pas contre les injections de buffer, il faut vérifier la longueur des informations avant de les entrer en mémoire.
De plus les systèmes d'exploitation sont censés garantir une isolation entre les applications de sorte que l'on ne puisse pas aller modifier l'état d'un autre programme que celui que l'on utilise. (Au pire des cas, il est donc uniquement possible de modifier l'état du programme en cours)
