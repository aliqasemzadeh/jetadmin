<flux:modal name="user.support.ticket.create.modal" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.create_ticket') }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.create_ticket_description') }}</flux:text>
        </div>

        <!-- Modal body -->
        <form wire:submit="create" method="post">
            <div class="pb-2">
                <flux:field>
                    <flux:field>
                        <flux:label>{{ __('jetadmin.title') }}</flux:label>

                        <flux:input wire:model="title" type="text" />

                        <flux:error name="title" />
                    </flux:field>
                </flux:field>

            </div>
            <button type="submit" class="btn-default btn-indigo w-full">
                {{ __('jetadmin.create') }}
            </button>
        </form>
    </div>
</flux:modal>
