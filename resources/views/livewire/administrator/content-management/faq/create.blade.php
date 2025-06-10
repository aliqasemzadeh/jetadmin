<flux:modal name="administrator.content-management.faq.create.modal" class="md:w-2/3">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.create_faq') }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.create_faq_description') }}</flux:text>
        </div>

        <!-- Modal body -->
        <form wire:submit="create" method="post">
            <div class="pb-2 space-y-4">
                <flux:field>
                    <flux:label>{{ __('jetadmin.question') }}</flux:label>
                    <flux:textarea wire:model="question"></flux:textarea>
                    <flux:error name="question" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('jetadmin.answer') }}</flux:label>
                    <flux:textarea wire:model="answer" class="h-64"></flux:textarea>
                    <flux:error name="answer" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('jetadmin.language') }}</flux:label>
                    <flux:select wire:model="language">
                        @foreach(__('jetadmin.languages') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="language" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('jetadmin.sort_order') }}</flux:label>
                    <flux:input wire:model="sort_order" type="number" />
                    <flux:error name="sort_order" />
                </flux:field>
            </div>
            <button type="submit" class="btn-default btn-indigo w-full">
                {{ __('jetadmin.create') }}
            </button>
        </form>
    </div>
</flux:modal>
