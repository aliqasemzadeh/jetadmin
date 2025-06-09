<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('jetadmin.categories') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.categories_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:administrator.setting-management.category.create />
    <livewire:administrator.setting-management.category.edit />
    <livewire:administrator.setting-management.category.table />
</div>
