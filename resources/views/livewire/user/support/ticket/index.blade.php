<div>
    <x-slot name="title">
        {{ __('jetadmin.tickets') }}
    </x-slot>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('jetadmin.tickets') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.tickets_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    <livewire:user.support.ticket.create />
    <livewire:user.support.ticket.table />
</div>
