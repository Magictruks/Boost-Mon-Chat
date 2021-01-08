# eval-symfony-2

## Get Started
   Installation dependencies
  
  ```shell
  composer install
  ```
  
   Change DATABASE_URL and MAILER_DNS in .env
  
   Create database
  
  ```shell
  php bin/console doctrine:database:create
  ```
  
   Generate fixtures
  
  
  ```shell
  php bin/console doctrine:fixtures:load
  ```
  
   Run serve
  
  ```shell
  symfony serve
  ```

Précision :

- J'ai utilisé une variable d'environement pour accéder au dossier var/session afin de pour afficher le nombre de fichier de session généré pour compter le nombre de visite sur le site (je ne suis pas sur de la méthode). Il faut donc l'ajouter dans le .env ou .env.local
ex: DIR_URL=D:\turch\Documents\Cours_IFA\4_-_Framework_PHP\eval-symphony-2\

- J'ai utilisé Mailer pour envoyé un mail/notification quand une demande est créer. Voir dans le .env le MAILER_DNS
