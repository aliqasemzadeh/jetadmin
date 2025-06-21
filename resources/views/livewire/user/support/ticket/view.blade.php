<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ $ticket->title }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('jetadmin.tickets_description') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>


        <form wire:submit="replay" method="post">
            <div>
                <flux:heading size="lg">{{ __('jetadmin.replay') }}</flux:heading>
            </div>
            <flux:field>
                <flux:label>{{ __('jetadmin.body') }}</flux:label>

                <flux:textarea rows="auto" wire:model="body" />
                <flux:error name="body" />
            </flux:field>
            <flux:field>
                <flux:label>{{ __('jetadmin.files') }}</flux:label>

                <flux:input wire:model="files" type="file" multiple />

                <flux:error name="files" />
            </flux:field>
            <div class="space-y-2">
                <flux:button type="submit" class="w-full mt-2">{{ __('jetadmin.replay') }}</flux:button>
            </div>
        </form>


    @foreach($replays as $replay)
        <flux:callout variant="secondary" icon="chat-bubble-left-right" inline class="mt-4">
            <flux:callout.heading>
                {{ $replay->user->name }} <flux:badge color="purple" size="sm" inset="top bottom">{{ $replay->created_at }}</flux:badge>
            </flux:callout.heading>
            <flux:callout.text>
                <p>{{ $replay->body }}</p>
                @if($replay->files->count() > 0)
                    @foreach($replay->files as $file)
                        <flux:button wire:click="downloadFile({{ $file }})">{{ $file->title }}</flux:button>
                    @endforeach
                @endif
            </flux:callout.text>
        </flux:callout>
    @endforeach

</div>
