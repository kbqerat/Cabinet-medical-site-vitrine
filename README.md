# MediAssist — Site Vitrine

Site de présentation du logiciel de gestion de cabinet médical **MediAssist**.

## Stack technique

- **Laravel 13** — Backend & rendu des vues
- **Blade** — Templating
- **Tailwind CSS** — Styles
- **Vite** — Bundler

## Installation

```bash
git clone https://github.com/kbqerat/Cabinet-medical-site-vitrine.git
cd Cabinet-medical-site-vitrine
composer install
npm install
copy .env.example .env
php artisan key:generate
```

## Lancer le projet

```bash
php artisan serve
npm run dev
```

Ouvrir `http://localhost:8000`

## Structure

```
resources/views/
├── layouts/        # Layout principal
├── components/     # Navbar, Footer, Contact
├── sections/       # Sections de la page d'accueil
└── home.blade.php  # Page principale
```

## Projet

Site vitrine dans le cadre d'un PFE — transformation d'une application de cabinet médical en produit SaaS commercial.
