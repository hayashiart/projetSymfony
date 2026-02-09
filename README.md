
```markdown
# Agenda Événements – Projet Symfony 7

**Projet Académique – Framework Symfony**

Application web complète de gestion d'événements réalisée avec **Symfony 7** dans le cadre d'un projet scolaire.

## Captures d'écran

### Page d'accueil
![Page d'accueil](images/accueil.png)

### Tableau de bord Administration
![Tableau de bord admin](images/admin.png)

### Page de connexion
![Page de connexion](images/connexion.png)

### Création d'un événement
![Création événement](images/creationEvenement.png)

### Mes événements
![Mes événements](images/mesEvenements.png)

### (ajoute d'autres captures si tu en as plus)
![Autre capture](images/autre-capture.png)

## Présentation du projet

**Thème choisi** : Gestion d'événements / Agenda

**Objectif principal**  
Permettre aux utilisateurs de créer, modifier, supprimer et lister leurs événements personnels ou partagés, avec un système d'authentification et de rôles sécurisé.

**Public cible**  
- Utilisateurs particuliers (organisation d'événements personnels, sorties, ateliers, etc.)  
- Administrateurs (gestion globale et modération future)

## Choix techniques et justification

- **PHP** : 8.3 (typé strict, performances modernes, compatibilité Symfony 7)  
- **Symfony** : 7.x (version récente, recette `webapp`, communauté active)  
- **Doctrine ORM** : Entités, relations, migrations, repositories personnalisés  
- **Twig** : Héritage, filtres, boucles, conditions, inclusion de partials  
- **Bootstrap 5** : Design responsive rapide (via CDN)  
- **Sécurité** : Authentification complète, PasswordHasher, rôles, #[IsGranted], CSRF  
- **Bonnes pratiques** : MVC strict, PRG, Flash messages, autowiring, code DRY, contrôleurs légers  

## Fonctionnalités réalisées

### Authentification & Sécurité
- Inscription (email unique, mot de passe fort)  
- Connexion / Déconnexion  
- Rôles : `ROLE_USER` et `ROLE_ADMIN`  
- Protection des routes avec `#[IsGranted]`  
- Hashage des mots de passe (Symfony PasswordHasher)  
- Protection CSRF sur les formulaires sensibles  
- Vérification manuelle : seul l'organisateur peut modifier/supprimer son événement  

### Routage & Contrôleurs
- Au moins 3 contrôleurs : `HomeController`, `SecurityController`, `EventController`  
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
- (prévu en évolution) : espace admin dédié  

## Installation locale (pas à pas)

1. Cloner le dépôt

```bash
git clone https://github.com/[tonusername]/agenda-symfony.git
cd agenda-symfony
```

2. Installer les dépendances

```bash
composer install
```

3. Configurer la base de données

Copiez `.env` en `.env.local` et modifiez `DATABASE_URL` selon votre configuration :

```env
DATABASE_URL="mysql://root:votre-mot-de-passe@127.0.0.1:3306/agenda_symfony?serverVersion=8.0&charset=utf8mb4"
```

4. Créer et migrer la base

```bash
php bin/console doctrine:database:create --if-not-exists
php bin/console doctrine:migrations:migrate --no-interaction
```

5. Charger les fixtures (données de test)

```bash
php bin/console doctrine:fixtures:load --no-interaction
```

6. Lancer le serveur Symfony

```bash
symfony serve
# ou si vous préférez sans https :
# symfony serve --no-tls
```

7. Accéder à l'application  
http://127.0.0.1:8000 (ou le port indiqué)

### Comptes de test

| Rôle       | Email             | Mot de passe | Description                     |
|------------|-------------------|--------------|---------------------------------|
| Admin      | admin@agenda.fr   | admin123     | ROLE_ADMIN – gestion complète   |
| Utilisateur| user@agenda.fr    | user123      | ROLE_USER – événements perso    |

## Difficultés rencontrées & solutions

- Connexion MySQL refusée → installation extension `php8.3-mysql` + correction `DATABASE_URL`  
- Erreur Twig "controller_name does not exist" → suppression template par défaut  
- "Access denied" édition → ajout vérification organisateur == user actuel  
- Routes non trouvées → ajout manuel méthodes + annotations routes  
- `createdAt` null → correction setter et valeur par défaut  
- Erreur Intelephense (IDE) → commande `php bin/console cache:clear` + reload window  

## Pistes d'amélioration futures

- Voter Symfony pour gestion fine des permissions  
- Espace administration complet (liste utilisateurs, modération événements)  
- Recherche / filtres avancés (titre, dates, lieu)  
- Upload d’image par événement  
- Intégration FullCalendar.js (vue calendrier)  
- Notifications email (Mailjet / Symfony Mailer)  
- Tests PHPUnit (unitaires + fonctionnels)  
- Pagination + tris sur les listes d'événements  
- API REST (futur support application mobile)  

---

**Projet réalisé par** : Sébastien Lin  
**Période** : Février 2026  

Bon courage pour la soutenance !
```
