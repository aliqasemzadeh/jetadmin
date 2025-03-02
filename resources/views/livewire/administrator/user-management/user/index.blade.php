<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('jetadmin.users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.users_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <button wire:click="$dispatch('openModal', {component: 'administrator.user-management.user.create'})">{{ __('jetadmin.create') }} {{ __('jetadmin.user') }}</button>
    <livewire:administrator.usermanagement.user.table />
</div>
