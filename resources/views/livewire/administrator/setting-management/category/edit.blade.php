<flux:modal name="administrator.setting-management.category.edit.modal" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.edit_category') }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.edit_category_description') }}</flux:text>
        </div>

        <!-- Modal body -->
        <form wire:submit="update" method="post">
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
                    @if($oldImage)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $oldImage) }}" alt="Current Image" class="w-32 h-32 object-cover rounded">
                            <p class="text-sm text-gray-500 mt-1">{{ __('jetadmin.current_image') }}</p>
                        </div>
                    @endif
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
                {{ __('jetadmin.update') }}
            </button>
        </form>
    </div>
</flux:modal>
