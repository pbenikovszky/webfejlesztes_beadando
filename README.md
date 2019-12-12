# Webfejlesztés beadandó
### Benikovszky Péter - AZ3OS2

Két megoldás a Webfejlesztés (ILBPM0522-17) órán kiadott beadandó feladatra

## Simple PHP
Ez a megoldás egyetlen php file-ból áll, egy egyszerű, igényes login formmal. Mellékelve van a password.txt file, aminek az index.php file-al azonos könyvtárban kell lennie.

## Full page
Ez a megoldás több file-t tartalmaz:
- index.html: ez a main file, ezt tartalmazza a login formot, ami egy POST requesttel továbbítja az adatokat a php file-nak
- login.php: maga a php file ami feldolgozza a login form-tól kapott adatokat
- style.css: az index.html-hez tartozó style sheet 
- password.txt: a kódolt jelszavakat és felhasználóneveket tartalmazó file, melynek egy könyvtárban kell lennie a login.php file-al
- sad.png: ez az emoji jelenik meg ha nem létező felhasználónevet ad meg a user
- ik.jpg: háttérkép a login formhoz
