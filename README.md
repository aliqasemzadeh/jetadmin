# JetAdmin

Livewire starter kit is good but you need security then you have to roles and permissions, JetAdmin helps you to make admin panel in secure mode.

## Requirements

1. laravel
2. livewire
3. spatie/laravel-permission
4. wire-elements/modal
5. power-components/livewire-powergrid

## Installation
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

## ScreenShots
Check out the following screenshots for more visual information:

- [Sidebar Menus](screenshot/sidebar-menus.jpg)
- [Users](screenshots/users.jpg)
- [User Permissions](screenshot/user-permissions.jpg)
- [User Roles](screenshot/user-roles.jpg)
- [Role Permissions](screenshot/role-permissions.jpg)
- [Active Sessions](screenshot/active-sessions.jpg)
