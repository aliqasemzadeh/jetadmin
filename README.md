!! This is page is under development don't use it in production mode. !!

✔️ Bootstrap Admin Panel (This is new version of bap with simple update and installation.)
======================
>  Easy way to create Admin Panel.
>
## 🔌 Requirements

- PHP version: >= 8.0
- Composer
- Node.js


## 🧰 Built with

- Laravel 10
- Livewire
- Bootstrap 5
- Tabler.io
- SweetAlert2
- spatie/laravel-permission
- Vite Build Tools


## 🧾 Installation

1. Install clean version of laravel
2. `composer install`
3. `composer require aliqasemzadeh/jetadmin`
4. Install dependencies:
   `npm install`
4. `cp .env.example .env`
5. `php artisan key:generate`
6. Set your `.env` with credentials to your database server (`DB_*` settings) and your domain config (`APP_URL`).
7. `php artisan migrate --seed`
8. Build frontend with `npm run production` for production.
9. Run your server `php artisan serve`.
10. Username:info@jetadmin.local/Password:P@ssw0rd321


Note:
I decide to change Base Admin Panel to Bootstrap Admin Panel because is much better.
