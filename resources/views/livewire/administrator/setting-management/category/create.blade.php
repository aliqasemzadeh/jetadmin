<flux:modal name="administrator.setting-management.category.create.modal" class="md:w-1/3">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.create_category') }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.create_category_description') }}</flux:text>
        </div>

        <!-- Modal body -->
        <form wire:submit="create" method="post">
            <div class="pb-2 space-y-4">
                <flux:field>
                    <flux:label>{{ __('jetadmin.title') }}</flux:label>
                    <flux:input wire:model="title" type="text" />
                    <flux:error name="title" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('jetadmin.type') }}</flux:label>
                    <flux:select wire:model="type">
                        @foreach(__('jetadmin.category_types') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="type" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('jetadmin.icon') }}</flux:label>
                    <flux:select wire:model="icon">
                        <option value="">{{ __('jetadmin.select_icon') }}</option>
                        @foreach(__('jetadmin.hero_icons') as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="icon" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('jetadmin.image') }}</flux:label>
                    <flux:input type="file" wire:model="image" />
                    <flux:error name="image" />
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
                    <flux:label>{{ __('jetadmin.description') }}</flux:label>
                    <flux:textarea wire:model="description"></flux:textarea>
                    <flux:error name="description" />
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
