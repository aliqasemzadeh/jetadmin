<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('jetadmin.faqs') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.faqs_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:administrator.content-management.faq.create />
    <livewire:administrator.content-management.faq.edit />
    <livewire:administrator.content-management.faq.table />
</div>
