<flux:modal name="administrator.content-management.article.edit.modal" class="md:w-1/3">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.edit_article') }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.edit_article_description') }}</flux:text>
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
                    <flux:label>{{ __('jetadmin.pre_title') }}</flux:label>
                    <flux:input wire:model="pre_title" type="text" />
                    <flux:error name="pre_title" />
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
                    <flux:label>{{ __('jetadmin.user') }}</flux:label>
                    <flux:select wire:model="user_id">
                        <option value="">{{ __('jetadmin.select_user') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="user_id" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('jetadmin.description') }}</flux:label>
                    <flux:textarea wire:model="description"></flux:textarea>
                    <flux:error name="description" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('jetadmin.body') }}</flux:label>
                    <flux:textarea wire:model="body" class="h-64"></flux:textarea>
                    <flux:error name="body" />
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
                    <flux:label>{{ __('jetadmin.public') }}</flux:label>
                    <flux:checkbox wire:model="public" />
                    <flux:error name="public" />
                </flux:field>
            </div>
            <button type="submit" class="btn-default btn-indigo w-full">
                {{ __('jetadmin.update') }}
            </button>
        </form>
    </div>
</flux:modal>
