# Guide de Lancement du Projet

## 🔧 Front-end

### 1. Installer npm

```bash
sudo apt install nodejs npm
```

### 2. Lancer le serveur du front-end

Déplacez-vous dans le dossier du front :

```bash
npm install
npm run dev
```

---

## 🖥️ Back-end

### 1. Installer PHP et Composer 

```bash
sudo apt install php
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 2. Lancer le serveur back-end

Déplacez-vous dans le dossier du projet Laravel :

```bash
composer install
php artisan serve
```
Remplacez la valeur de la variable $credentialsPath dans le fichier DialogFlowController.php (situé dans app/Http/Controllers) par le chemin absolu du fichier dialogflow-key.json.

Lancer la commade de migration de base des données :

```bash
php artisan migrate
```
---

## 🧪 Tester l'application

Ouvrez votre navigateur à l'adresse suivante :

```
http://localhost:5173/
```

Entrez une requête contenant plusieurs critères, comme :

- Un ou plusieurs **genres**
- Un **acteur** ou une **actrice**
- Une **période** (année ou intervalle d'années)
- Une **langue**

### Exemple de requête :

> je veux un film animation francais des annees 2010 d'horreur.
