# Agenda Événements – Projet Symfony 7  
**Projet Académique – Framework Symfony**

Application web complète de gestion d'événements réalisée avec **Symfony 7** dans le cadre d'un projet scolaire.

## Présentation du projet

**Thème choisi** : Gestion d'événements / Agenda  

**Objectif principal**  
Permettre aux utilisateurs de créer, modifier, supprimer et lister leurs événements personnels ou partagés, avec un système d'authentification et de rôles sécurisé.

**Public cible**  
- Utilisateurs particuliers (organisation d'événements personnels, sorties, ateliers, etc.)  
- Administrateurs (gestion globale et modération future)

## Captures d'écran

<div align="center">
  <img src="images/accueil.png" alt="Page d'accueil" width="45%">
  <img src="images/mesEvenements.png" alt="Mes événements" width="45%">
</div>

<div align="center">
  <img src="images/creationEvenement.png" alt="Création d'un événement" width="45%">
  <img src="images/admin.png" alt="Tableau de bord Administration" width="45%">
</div>

<div align="center">
  <img src="images/connexion.png" alt="Page de connexion" width="45%">
</div>

## Choix techniques et justification

- **PHP** : 8.3 (typé strict, performances modernes, compatibilité Symfony 7)  
- **Symfony** : 7.x (version récente, recette `webapp`, communauté active)  
- **Doctrine ORM** : Entités, relations (ManyToOne / OneToMany), migrations, repositories personnalisés  
- **Twig** : Héritage de templates, filtres (date, slice), boucles/conditions  
- **Bootstrap 5** : Design responsive rapide et professionnel (via CDN)  
- **Sécurité** : Authentification complète, PasswordHasher, rôles (ROLE_USER / ROLE_ADMIN), protection des routes (#[IsGranted]), CSRF sur formulaires sensibles, Voter personnalisé pour permissions fines  
- **Patterns utilisés** : MVC strict, PRG (Post-Redirect-Get), Flash messages, autowiring, repositories personnalisés  
- **Bonnes pratiques** : Nommage explicite, DRY, pas de SQL brut, pas de "fat controllers", code lisible, commentaires, indentation PSR  

## Fonctionnalités réalisées

### Authentification & Sécurité
- Inscription (email unique, mot de passe fort)  
- Connexion / Déconnexion  
- Rôles : `ROLE_USER` et `ROLE_ADMIN`  
- Protection des routes avec `#[IsGranted]`  
- Hashage des mots de passe (Symfony PasswordHasher)  
- Protection CSRF sur les formulaires sensibles  
- Vérification manuelle + Voter : seul l'organisateur peut modifier/supprimer son événement  

### Routage & Contrôleurs
- Au moins 3 contrôleurs : `HomeController`, `SecurityController`, `EventController`, `AdminController`  
- Routes nommées et dynamiques (`/evenements/{id}/modifier`, etc.)  
- Utilisation de `path()` dans les templates  

### Templates Twig
- Layout principal (`base.html.twig`) avec héritage  
- Navbar conditionnelle selon rôle/connecté  
- Utilisation de `{% for %}`, `{% if %}`, filtres `date`, `slice`, `length`  
- Design responsive Bootstrap 5  

### Doctrine ORM
- Entités principales :  
  - `User` (email, password, roles)  
  - `Event` (title, description, startDate, endDate, location, createdAt, organizer)  
- Relations : ManyToOne (Event → User) + OneToMany (User → Events)  
- Migrations automatiques  
- Repository personnalisé (`EventRepository`)  
- Fixtures (2 utilisateurs + 4 événements de test)  

### Formulaires & Validation
- Création d'événement (`new`)  
- Modification d'événement (`edit`) avec pré-remplissage  
- Validation automatique + affichage des erreurs  
- Messages flash (success/error)  

### Administration
- Rôle `ROLE_ADMIN` fonctionnel  
- Tableau de bord admin : statistiques + liste complète des événements  

## Installation locale (pas à pas)

1. Cloner le dépôt  
   ```bash
   git clone https://github.com/[tonusername]/agenda-symfony.git
   cd agenda-symfony

Installer les dépendancesBashcomposer install
Configurer la base de données
Copier .env en .env.local et adapter DATABASE_URL :dotenvDATABASE_URL="mysql://root:Seb12345!@127.0.0.1:3306/evenement_agenda?serverVersion=8.0&charset=utf8mb4"
Créer et migrer la baseBashphp bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
Charger les fixtures (données de test)Bashphp bin/console doctrine:fixtures:load --no-interaction
Lancer le serveurBashsymfony serve --no-tls
Accéder à l'application
http://127.0.0.1:8000

Comptes de test























RôleEmailMot de passeDescriptionAdminadmin@agenda.fradmin123ROLE_ADMIN – gestion complèteUtilisateuruser@agenda.fruser123ROLE_USER – événements perso
Difficultés rencontrées & solutions apportées

Connexion MySQL refusée → installation extension php8.3-mysql + correction DATABASE_URL
Erreur Twig "controller_name does not exist" → remplacement du template par défaut
"Access denied" sur édition → vérification manuelle organisateur (puis Voter)
Routes non trouvées → ajout manuel des méthodes + routes
createdAt null → correction setter setCreatedAt(?\DateTime $createdAt)
Erreur autowire Voter → remplacement Security par AuthorizationCheckerInterface
Erreur IDE (rouge sur EventRepository) → clear cache Intelephense + reload window

Pistes d'amélioration futures

Voter Symfony pour gestion fine des permissions
Espace administration complet (liste utilisateurs, modération événements)
Recherche / filtres avancés (titre, dates, lieu)
Upload d’image par événement
Intégration FullCalendar.js (vue calendrier)
Notifications email (Mailjet / Symfony Mailer)
Tests PHPUnit (unitaires + fonctionnels)
Pagination + tris sur les listes d'événements
API REST (futur support application mobile)


Projet réalisé par : Sébastien Lin
Période : Février 2026
Lien GitHub : https://github.com/[tonusername]/agenda-symfony
Bon courage pour la soutenance !
text### Instructions pour l’utiliser

1. Remplace `[tonusername]` par ton vrai pseudo GitHub (ex: hayashiart)  
2. Copie-colle tout dans `README.md`  
3. Commit et pousse :

```bash
git add README.md
git commit -m "README final ultra-détaillé avec captures intégrées"
git push