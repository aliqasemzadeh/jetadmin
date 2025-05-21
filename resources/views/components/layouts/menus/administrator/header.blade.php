<a href="{{ route('administrator.dashboard.index') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
    <x-app-logo />
</a>

<flux:navbar class="-mb-px max-lg:hidden">
    @can('administrator_dashboard_index')
        <flux:navbar.item icon="home" :href="route('administrator.dashboard.index')" :current="request()->routeIs('administrator.dashboard.index')" wire:navigate>{{ __('jetadmin.dashboard') }}</flux:navbar.item>
    @endcan

    @can('administrator_user_managements')
        @can('administrator_user_index')
            <flux:navbar.item icon="user-group" :href="route('administrator.user-management.user.index')" :current="request()->routeIs('administrator.user-management.user.index')" wire:navigate>{{ __('jetadmin.users') }}</flux:navbar.item>
        @endcan
        @can('administrator_user_role_index')
            <flux:navbar.item icon="user-circle" :href="route('administrator.user-management.role.index')" :current="request()->routeIs('administrator.user-management.role.index')" wire:navigate>{{ __('jetadmin.roles') }}</flux:navbar.item>
        @endcan
        @can('administrator_user_permission_index')
            <flux:navbar.item icon="adjustments-vertical" :href="route('administrator.user-management.permission.index')" :current="request()->routeIs('administrator.user-management.permission.index')" wire:navigate>{{ __('jetadmin.permissions') }}</flux:navbar.item>
        @endcan
    @endcan
</flux:navbar>
