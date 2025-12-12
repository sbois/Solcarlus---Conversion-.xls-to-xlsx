# 🏛️ SOLCARLUS - Convertisseur XLS vers XLSX

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-%3E%3D7.4-8892BF.svg)
![Status](https://img.shields.io/badge/status-active-success.svg)

> *"Veni, Vidi, Converti"* - Je suis venu, j'ai vu, j'ai converti

**Solcarlus** est un convertisseur XLS vers XLSX avec une interface web moderne inspirée de la Rome antique et des gladiateurs. Conçu pour les serveurs XAMPP/LAMP, il permet de convertir facilement un ou plusieurs fichiers Excel au format legacy (.xls) vers le format moderne (.xlsx).

![Solcarlus Interface](https://github.com/sbois/Solcarlus---Conversion-.xls-to-xlsx/blob/main/capture.png)

## ✨ Fonctionnalités

- ⚔️ **Conversion par lot** : Convertissez jusqu'à 20 fichiers simultanément
- 🎨 **Interface gladiateur** : Design unique inspiré du Colisée de Rome
- 📱 **Responsive** : Fonctionne sur desktop, tablette et mobile
- 🚀 **Drag & Drop** : Glissez-déposez vos fichiers
- 🔒 **Sécurisé** : Validation des fichiers et nettoyage automatique
- 💾 **Téléchargement automatique** : Les fichiers convertis se téléchargent instantanément
- 🧹 **Auto-nettoyage** : Suppression des fichiers temporaires après 1 heure

## 🖼️ Aperçu

L'interface présente :
- Un design épique avec fond Colisée romain
- Palette de couleurs bronze, or et rouge sang
- Typographie évoquant l'époque romaine
- Animations fluides et interactions modernes

## 📋 Prérequis

- **Serveur** : XAMPP, WAMP, LAMP ou tout serveur Apache/PHP
- **PHP** : Version 7.4 ou supérieure
- **Composer** : Pour l'installation des dépendances
- **Extensions PHP requises** :
  - `zip`
  - `gd`
  - `mbstring`
  - `xmlreader`
  - `xmlwriter`
  - `simplexml`
  - `dom`

## 🚀 Installation

### 1. Cloner le dépôt

```bash
cd /path/to/htdocs  # ou /var/www/html sur Linux
git clone https://github.com/votre-username/solcarlus.git
cd solcarlus
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Créer le dossier uploads

```bash
mkdir uploads
chmod 777 uploads  # Sur Linux/Mac
```

Sur Windows, donnez les droits en écriture au dossier `uploads`.

### 4. Configuration PHP

Éditez votre fichier `php.ini` (généralement dans `C:\xampp\php\php.ini` ou `/etc/php/php.ini`) :

```ini
upload_max_filesize = 50M
post_max_size = 50M
max_file_uploads = 20
max_execution_time = 600
memory_limit = 512M
max_input_vars = 3000
```

**Important** : Redémarrez Apache après modification du php.ini !

### 5. Accéder à l'application

Ouvrez votre navigateur et accédez à :
```
http://localhost/solcarlus/
```

## 📁 Structure du projet

```
solcarlus/
├── vendor/              # Dépendances Composer (généré)
├── uploads/             # Fichiers temporaires (à créer)
├── composer.json        # Configuration Composer
├── composer.lock        # Verrouillage des versions
├── index.php            # Interface utilisateur
├── convert.php          # Script de conversion
└── README.md            # Ce fichier
```

## 🔧 Utilisation

1. **Sélectionnez** vos fichiers .xls (cliquez ou glissez-déposez)
2. **Vérifiez** la liste des fichiers à convertir
3. **Cliquez** sur "⚔️ CONVERTIR EN XLSX ⚔️"
4. **Téléchargez** automatiquement vos fichiers convertis

## 📦 Dépendances

- **[phpoffice/phpspreadsheet](https://github.com/PHPOffice/PhpSpreadsheet)** v1.29+ : Bibliothèque puissante pour manipuler les fichiers Excel

Les dépendances suivantes sont installées automatiquement :
- maennchen/zipstream-php
- markbaker/complex
- markbaker/matrix
- psr/simple-cache

## 🔒 Sécurité

- ✅ Validation stricte des extensions de fichiers (.xls uniquement)
- ✅ Limitation de taille (10 MB par fichier par défaut)
- ✅ Noms de fichiers uniques avec `uniqid()`
- ✅ Nettoyage automatique des fichiers temporaires (1 heure)
- ✅ Vérification des erreurs d'upload
- ✅ Gestion sécurisée des chemins de fichiers

## ⚙️ Configuration

### Modifier la taille maximale des fichiers

Dans `convert.php`, ligne 12 :
```php
$maxFileSize = 10 * 1024 * 1024; // 10 MB
```

### Modifier le temps de conservation des fichiers

Dans `convert.php`, ligne 18 :
```php
cleanOldFiles($uploadDir, 3600); // 3600 secondes = 1 heure
```

## 🐛 Dépannage

### Erreur "Class not found"
```bash
composer dump-autoload
```

### Erreur de permissions sur uploads/
```bash
chmod 777 uploads  # Linux/Mac
# Ou donner les droits manuellement sur Windows
```

### Timeout lors de la conversion
Augmentez `max_execution_time` dans php.ini

### Erreur de mémoire
Augmentez `memory_limit` dans php.ini

### Impossible d'uploader plusieurs fichiers
Vérifiez `max_file_uploads` dans php.ini (minimum 20)

### Erreur JSON lors de multiples conversions
Assurez-vous que `post_max_size` est suffisamment élevé

## 🧪 Test des limites PHP

Créez un fichier `test.php` :
```php
<?php
phpinfo();
```

Accédez à `http://localhost/solcarlus/test.php` et vérifiez les valeurs :
- upload_max_filesize
- post_max_size
- max_file_uploads
- memory_limit
- max_execution_time

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :

1. Fork le projet
2. Créer une branche (`git checkout -b feature/amelioration`)
3. Commit vos changements (`git commit -m 'Ajout d'une fonctionnalité'`)
4. Push vers la branche (`git push origin feature/amelioration`)
5. Ouvrir une Pull Request

## 📝 Licence

Ce projet est sous licence GPL v3

## 👤 Auteur

Créé avec ⚔️ par [Steeve BOIS] à l'aide de ClaudAI

## 🙏 Remerciements

- [PHPOffice/PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet) pour la bibliothèque de manipulation Excel
- L'Empire Romain pour l'inspiration épique 🏛️

## 📧 Support

Pour toute question ou problème :
- Ouvrez une [issue](https://github.com/sbois/Solcarlus---Conversion-.xls-to-xlsx/issues)
- Contactez-moi via [https://www.steevebois.com]

---

<p align="center">
  <strong>⚔️ Veni, Vidi, Converti ⚔️</strong><br>
  Made with ❤️ and 🏛️
</p>
