<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('jetadmin.articles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.articles_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:administrator.content-management.article.create />
    <livewire:administrator.content-management.article.edit />
    <livewire:administrator.content-management.article.table />
</div>
