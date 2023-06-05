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
5. Set middleware routes to Kernel.php
   ```php
        'referral' => \Questocat\Referral\Http\Middleware\CheckReferral::class,
        'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
   ```
6. `cp .env.example .env`
7. `php artisan key:generate`
8. Set your `.env` with credentials to your database server (`DB_*` settings) and your domain config (`APP_URL`).
9. `php artisan migrate --seed`
10. Build frontend with `npm run production` for production.
11. Run your server `php artisan serve`.
12. Username:info@jetadmin.local/Password:P@ssw0rd321


Note:
I decide to change Base Admin Panel to Bootstrap Admin Panel because is much better.
