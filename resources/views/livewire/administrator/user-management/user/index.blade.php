<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('jetadmin.users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.users_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:administrator.user-management.user.create />
    <livewire:administrator.user-management.user.edit />
    <livewire:administrator.user-management.user.roles />
    <livewire:administrator.user-management.user.permissions />
    <livewire:administrator.user-management.user.table />
</div>
