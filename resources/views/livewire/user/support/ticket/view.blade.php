<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ $ticket->title }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.tickets_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>


        <form wire:submit="replay" method="post">
            <div>
                <flux:heading size="lg">{{ __('jetadmin.body') }}</flux:heading>
            </div>
            <flux:textarea rows="auto" wire:model="body" />
            <div class="space-y-2">
                <flux:button type="submit" class="w-full mt-2">{{ __('jetadmin.replay') }}</flux:button>
            </div>
        </form>


    @foreach($replays as $replay)
        <flux:callout variant="secondary" icon="chat-bubble-left-right" inline class="mt-6">
            <flux:callout.heading>
                {{ $replay->user->name }} <flux:badge color="purple" size="sm" inset="top bottom">{{ $replay->created_at }}</flux:badge>
            </flux:callout.heading>
            <flux:callout.text>
                <p>{{ $replay->body }}</p>
            </flux:callout.text>
        </flux:callout>
    @endforeach

</div>
