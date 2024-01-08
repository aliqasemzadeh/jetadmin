!! This is page is under development don't use it in production mode. !!

✔️ JetAdmin
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
- TailwindCSS
- SweetAlert2
- spatie/laravel-permission
- Vite Build Tools
- daisyUI


## 🧾 Installation

1. Install clean version of laravel
2. `composer install`
3. `composer require aliqasemzadeh/jetadmin`
4. Install dependencies:
   `npm install`
6. `cp .env.example .env`
7. `php artisan key:generate`
8. Set your `.env` with credentials to your database server (`DB_*` settings) and your domain config (`APP_URL`).
9. Set middleware routes to Kernel.php
```php
     'referral' => \Questocat\Referral\Http\Middleware\CheckReferral::class,
     'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
     'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
     'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
     'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
     'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class
```
10. Clean all routes in `web.php`
11. `php artisan migrate --seed`
12. Build frontend with `npm run production` for production.
13. Run your server `php artisan serve`.
14. Username:info@jetadmin.ir/Password:P@ssw0rd321


Note:
I am building basic admin panel to make laravel programmer do codes better.
