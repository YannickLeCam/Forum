# Forum
Est un projet effectué lors de ma formation a Elan Formation, ce projet est composé d'un mini-framework créé par Elan en PHP


## Fonctionnalité du Forum

### Sur le projet Forum vous aller pouvoir faire :

- Création d'un compte
- Connexion
- Créer des topic et les supprimer
- Créer des posts ainsie que les modifier de facons très intuitive et les supprimmer
- Gestion de Role (Admin / User)
- Bannissement de compte user par les admins
- Le forum sera fonctionnel sur desktop et tablette (Mobile le responsive n'est pas finit
- Voir les activité d'un utilisateur en particulier lorsqu'on est admin

### Amélioration possible :

- Ajouter des photo de profil pour avoir un rendu plus vivant
- Ajouter le responsive pour Mobile

## Securité 

### Faille XSS

Toute les failles XSS sont normalment géré grâce a des "filters" et un traitement de données classique

### CSRF 

La vulnérabilité CSRF est géré grace a un token déposé en méta et mis dans la session afin de rendre une session totalement sécurisé 

### Injection SQL

J'ai pu mettre en place des requete préparer et sécurisé grâce a PDO qui va empècher cette vulnérabilité.

## Accessibilité 

J'ai éssayé de faire en sorte que le site soit le plus accessible a tous, en utilisant des coouleurs dont la chromatique ne semble pas s'entrechoqué permettant une lecture fluide et claire pour les personnes souffrant de daltonnisme.

