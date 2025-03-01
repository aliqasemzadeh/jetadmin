<a href="{{ route('administrator.dashboard.index') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
    <x-app-logo />
</a>

<flux:navlist variant="outline">
    <flux:navlist.group heading="{{ __('jetadmin.panels.administrator') }}" class="grid">
        <flux:navlist.item icon="home" :href="route('administrator.dashboard.index')" :current="request()->routeIs('administrator.dashboard.index')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
    </flux:navlist.group>

    <flux:navlist.group heading="{{ __('jetadmin.user_managements') }}" class="grid">
        <flux:navlist.item icon="user-group" href="{{ route('administrator.user-management.user.index') }}" :current="request()->routeIs('administrator.user-management.user.index')" wire:navigate>{{ __('jetadmin.users') }}</flux:navlist.item>
        <flux:navlist.item icon="user-circle" href="{{ route('administrator.user-management.role.index') }}" :current="request()->routeIs('administrator.user-management.role.index')" wire:navigate>{{ __('jetadmin.roles') }}</flux:navlist.item>
        <flux:navlist.item icon="adjustments-vertical" href="{{ route('administrator.user-management.permission.index') }}" :current="request()->routeIs('administrator.user-management.permission.index')" wire:navigate>{{ __('jetadmin.permissions') }}</flux:navlist.item>
    </flux:navlist.group>
</flux:navlist>
