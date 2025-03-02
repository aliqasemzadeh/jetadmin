<a href="{{ route('user.dashboard.index') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
    <x-app-logo />
</a>

<flux:navlist variant="outline">
    @can('user_access')
    <flux:navlist.group heading="{{ __('jetadmin.panels.user') }}" class="grid">
        @can('user_dashboard')<flux:navlist.item icon="home" :href="route('user.dashboard.index')" :current="request()->routeIs('user.dashboard.index')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>@endcan
        @can('user_settings')<flux:navlist.item icon="cog" :href="route('user.settings.profile')" :current="request()->routeIs('user.settings.*')" wire:navigate>{{ __('Settings') }}</flux:navlist.item>@endcan
    </flux:navlist.group>
    @endcan
</flux:navlist>
