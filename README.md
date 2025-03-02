#JetAdmin

Livewire starter kit is good but you need security then you have to roles and permissions, JetAdmin helps you to make admin panel in secure mode.

##Requirements

1.laravel
2.livewire
3.spatie/laravel-permission
4.wire-elements/modal
5.power-components/livewire-powergrid

##Installation
First .env file for project.

Now run migrate to make database:
```bash
php artisan migrate
```

Import Roles:
```bash
php artisan system:administrator:create-roles-command
```

Import Permissions:
```bash
php artisan system:administrator:create-permissions-command
```

Create Administrator:
```bash
php artisan system:administrator:create-administrator-command
```

Done.

