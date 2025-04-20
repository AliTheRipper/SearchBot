# Guide de Lancement du Projet

## 🔧 Front-end

### 1. Installer npm (si ce n’est pas déjà fait)

```bash
sudo apt install nodejs npm
```

### 2. Lancer le serveur du front-end

Déplace-toi dans le dossier du front :

```bash
npm install
npm run dev
```

---

## 🖥️ Back-end

### 1. Installer Composer (si ce n’est pas déjà fait)

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

### 2. Lancer le serveur back-end

Déplace-toi dans le dossier du projet Laravel :

```bash
composer install
php artisan serve
```

---

## 🧪 Tester l'application

Ouvre ton navigateur à l'adresse suivante :

```
http://localhost:5173/
```

Entre une requête contenant plusieurs critères, comme :

- Un ou plusieurs **genres**
- Un **acteur** ou une **actrice**
- Une **période** (année ou intervalle d'années)
- Une **langue**

### Exemple de requête :

> je veux un film animation francais des annees 2010 d'horreur.
