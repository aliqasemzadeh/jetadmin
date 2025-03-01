<a href="{{ route('user.dashboard.index') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
    <x-app-logo />
</a>

<flux:navlist variant="outline">
    <flux:navlist.group heading="{{ __('jetadmin.panels.user') }}" class="grid">
        <flux:navlist.item icon="home" :href="route('user.dashboard.index')" :current="request()->routeIs('user.dashboard.index')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
    </flux:navlist.group>
</flux:navlist>
