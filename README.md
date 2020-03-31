# projet-1

git clone https://github.com/Projet-collectif/projet-1.git 

composer install

Base de données:

- fichier sql dans dossier "sql" du projet
- copier le fichier .env et le renommer en .env.local
- ligne 28 du fichier .env.local 
  DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/projet-1?serverVersion=5.7
  
  modifier les variables suivantes selon votre configuration
  - remplacer db_user par votre login de votre phpmyadmin
  - remplacer db_password par votre mot de passe 
  
 lancement du projet:
 
 php bin/console server:run
 
 et pour finir :)
 
 faire une branch pour votre développement 
 
 git checkout -B ma_branche
