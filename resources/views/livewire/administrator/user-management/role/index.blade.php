<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('jetadmin.roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.roles_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:administrator.user-management.role.create />
    <livewire:administrator.user-management.role.edit />
    <livewire:administrator.user-management.role.users />
    <livewire:administrator.user-management.role.permissions />
    <livewire:administrator.user-management.role.table />
</div>
