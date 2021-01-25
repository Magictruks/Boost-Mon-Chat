# BootsMonChat

<p align="center">
  <!-- <a href="https://github.com/othneildrew/Best-README-Template">
    <img src="images/logo.png" alt="Logo" width="80" height="80">
  </a> -->

  <h3 align="center">BootsMonChat</h3>

  <p align="center">
    Evaluation Symfony Janvier 2021 - IFA Metz
    <!-- <br />
    <a href="https://github.com/othneildrew/Best-README-Template"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/othneildrew/Best-README-Template">View Demo</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Report Bug</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Request Feature</a>
  </p> -->
</p>

<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#preambule">Preambule</a></li>
         <li><a href="#feature">Feature</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li>
      <a href="#usage">Usage</a>
      <ul>
<!--         <li><a href="#new-project">New Project</a></li>
        <li><a href="#initialisation-database">Initialisation Database</a></li>
        <li><a href="#create-entity">Create Entity</a></li>
        <li><a href="#create-file-entity-for-upload-file">Create File Entity for Upload File</a></li>
        <li><a href="#create-auth-+-jwt">Create Auth + JWT</a></li> -->
      </ul>
    </li>
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

## About The Project

### Preambule

BoostMonChat est le nom d'une entreprise fictive créée dans le cadre d'un examen lors de mon parcours pour l'obtention de mon diplôme Developper Fullstack. La difficulté de l'exercice était la durée de 4 jours pour réaliser un panel de gestion de demande client. N'ayant pas fait de Symfony depuis un bon moment, j'ai fais de mon mieux pour relever le challenge et ajouter un maximum de fonctionnalité.

Le concept de cette interface est simple. Un auto-entrepreneur veut pouvoir centralisé les demandes des ses client et établir un suivi de celle-ci. Pour ce faire, il décide de créer une interface lui permettant de :

- répertorier ses clients
- répertorier les entreprises de ses clients
- inscrire des utilisateurs qui seront des comptes pour ses clients
- répertorier les demandes émisent par ses utilisateurs (client ayant un compte)
- établir un suivi de la demande du client qui sera visible par le client
- créer des tickets qui serviront uniquement à l'auto entrepreneur pour pouvoir s'organiser dans son travail

Ainsi, le client ayant un compte utilisateur pour se connecter sur le panel et y poster une demande. Une fois la demande pris en charge par l'auto entrepreneur, son status passera à "en cours" et l'auto entrepreneur créera des tickets comme un sorte de TODO list. Une fois la demande terminé, le status de la demande changera et le client pourra constater que sa demande est bien terminé.

### Feature

## Get Started

### Installation
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
## Usage

### Login

Pour vous connecter en tant qu'administrateur, vous pouvez utiliser les identifiants ci :
login : admin@admin.com
mdp: azerty

### Dashboard

Vous pouvez voir ici quelques stats : 
- le nombre d'utilisateur qui sont venu sur votre site
- le nombre de nouvelles demande
- le nombre de demandes en cours
- le nombre de tickets ouvert
- le nombre de tickets fermé
- le 10 dernières demandes

### Admin

Partie accessible par l'administrateur.

Vous pouvez agir sur les 3 entitées principales qui sont :
- Utilisateur
- Client
- Entreprise

Vous pouvez executer ces actions sur n'importe quelle entité :
- Ajouter
- Modifier
- Supprimer
- Afficher

### Demande

Partie accessible par l'administrateur et l'utilisateur.

L'utilisateur ne verra que ses propres demande et pour ajouter une demande.

L'administrateur pourra voir toutes ses demandes et pourra faire n'importe quel action dessus. Il pourra aussi changer le status de la demande en fonction de son avancé.

Une demande possède 4 status :
- Nouvelle
- En cours
- Terminé
- Archivé

Un petit badge à coté du menu Demande indique le nombre de nouvelles demandes.

### Ticket

Partie accessible par l'administrateur.

L'administrateur pourra voir tous les tickets qu'il a créer. Ainsi, il pourra facilement voir le status du ticket, le mettre à jour, et l'archivé. Il pourra :

- Créer un ticket
- Modifier un ticket
- Mettre à jour le status du ticket
- Supprimer le ticket
- Voir tous les tickets

Un petit badge à coté du menu Demande indique le nombre de tickets ouvert.

## Contact

Turchini Axel - [Linkedin](www.linkedin.com/in/axelturchini) - turchini.axel@gmail.com

Project Link: [https://github.com/Magictruks/auto_nodejs](https://github.com/Magictruks/auto_nodejs)


Précision :

- J'ai utilisé une variable d'environement pour accéder au dossier var/session afin de pour afficher le nombre de fichier de session généré pour compter le nombre de visite sur le site (je ne suis pas sur de la méthode). Il faut donc l'ajouter dans le .env ou .env.local
ex: DIR_URL=D:\turch\Documents\Cours_IFA\4_-_Framework_PHP\eval-symphony-2\

- J'ai utilisé Mailer pour envoyé un mail/notification quand une demande est créer. Voir dans le .env le MAILER_DNS
