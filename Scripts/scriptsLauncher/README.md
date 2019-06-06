Le script Main.py permet de lancer les différentes attaques réalisées pendant notre projet.

Plusieurs attaques ne sont utilisables que depuis ce launcher :
- Les scans réseaux
- Les scans de sites wordpress
- Les scans de sites 

# Les scans réseaux
- La première option permet de scanner un réseau est de découvrir l'ip de tous les appareils connectés à ce réseau. Pour cela on utilise l'outil nmap.
La commande utilisée est : 
`nmap -sP 172.16.0.0/24`
- La seconde option permet de scanner les ports d'un appareil connecté à votre réseau. Cette option permet aussi de lister les services actifs sur la machine cible.
La commande utilisée est :
`nmap -sV IPCible -A -v`
# Les scans de sites wordpress
Pour scanner les vulnérabilités des sites utilisant le framework WordPress on utilise l'utilitaire WPScan.
La commande utilisée est  : 
`wpscan --random-user-agent --url url` 

# Les scans de sites web
Pour scanner les vulnérabilités des sites on utilise l'utilitaire Nikto
La commande utilisée est : 
`nikto -h url`
