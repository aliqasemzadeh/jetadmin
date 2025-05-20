<flux:modal name="administrator.user-management.user.edit.modal" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.edit_user') }} : {{ $id }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.edit_user_description') }}</flux:text>
        </div>
        <form wire:submit="edit" method="post">
        <div class="pb-2">
            <flux:field>
                    <flux:label>{{ __('jetadmin.name') }}</flux:label>

                    <flux:input wire:model="name" type="text" />

                    <flux:error name="name" />
            </flux:field>
            <flux:field>
                <flux:label>{{ __('jetadmin.email') }}</flux:label>

                <flux:input wire:model="email" type="email" />

                <flux:error name="email" />
            </flux:field>
            <flux:field>
                <flux:label>{{ __('jetadmin.password') }}</flux:label>

                <flux:input wire:model="password" type="password" />

                <flux:error name="password" />
            </flux:field>
            <flux:field>
                <flux:label>{{ __('jetadmin.password_confirmation') }}</flux:label>

                <flux:input wire:model="password_confirmation" type="password" />

                <flux:error name="password_confirmation" />
            </flux:field>
        </div>
        <button type="submit" class="btn-default btn-indigo w-full">
            {{ __('jetadmin.update') }}
        </button>
    </form>
    </div>
</flux:modal>

