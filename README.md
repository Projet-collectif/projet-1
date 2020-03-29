# projet-1

git clone "le_projet" 

composer install

Base de données:

- fichier sql dans dossier "sql" du projet
- copier le fichier .env et le renommer en .env.local
- ligne 28 du fichier .env.local 
  DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7
  
  modifier les variables suivantes selon votre configuration
  - db_user = login de votre phpmyadmin
  - db_password = mot de passe 
  - db_name = nom de base de données
  
 lancement du projet:
 
 php bin/console server:run
