<a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
    <x-app-logo />
</a>

<flux:navlist variant="outline">
    <flux:navlist.group heading="{{ __('jetadmin.panels.administrator') }}" class="grid">
        <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
    </flux:navlist.group>

    <flux:navlist.group expandable heading="Favorites" class="hidden lg:grid">
        <flux:navlist.item href="#">Users</flux:navlist.item>
        <flux:navlist.item href="#">Roles</flux:navlist.item>
        <flux:navlist.item href="#">Permissions</flux:navlist.item>
    </flux:navlist.group>
</flux:navlist>
