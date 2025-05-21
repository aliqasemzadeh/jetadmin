<a href="{{ route('user.dashboard.index') }}" class="ml-2 mr-5 flex items-center space-x-2 lg:ml-0" wire:navigate>
    <x-app-logo />
</a>

<flux:navbar class="-mb-px max-lg:hidden">
    @can('user_access')
        @can('user_dashboard')
            <flux:navbar.item icon="home" :href="route('user.dashboard.index')" :current="request()->routeIs('user.dashboard.index') || request()->routeIs('dashboard')" wire:navigate>{{ __('jetadmin.dashboard') }}</flux:navbar.item>
        @endcan
        @can('user_settings')
            <flux:navbar.item icon="cog" :href="route('user.settings.profile')" :current="request()->routeIs('user.settings.*')" wire:navigate>{{ __('jetadmin.settings') }}</flux:navbar.item>
        @endcan
    @endcan
</flux:navbar>
