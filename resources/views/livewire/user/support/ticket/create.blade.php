<flux:modal name="user.support.ticket.create.modal" class="md:w-96" xmlns:flux="http://www.w3.org/1999/html">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.create_ticket') }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.create_ticket_description') }}</flux:text>
        </div>

        <!-- Modal body -->
        <form wire:submit="create" method="post">
            <div class="pb-2">
                <flux:field>
                        <flux:label>{{ __('jetadmin.title') }}</flux:label>

                        <flux:input wire:model="title" type="text" />

                        <flux:error name="title" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('jetadmin.category') }}</flux:label>
                    <flux:select wire:model="category_id">
                        <option value="">{{ __('jetadmin.select_category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="category_id" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('jetadmin.body') }}</flux:label>

                    <flux:textarea wire:model="body" type="textarea" />

                    <flux:error name="body" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('jetadmin.files') }}</flux:label>

                    <flux:input wire:model="files" type="file" multiple />

                    <flux:error name="files" />
                </flux:field>

            </div>
            <button type="submit" class="btn-default btn-indigo w-full">
                {{ __('jetadmin.create') }}
            </button>
        </form>
    </div>
</flux:modal>
