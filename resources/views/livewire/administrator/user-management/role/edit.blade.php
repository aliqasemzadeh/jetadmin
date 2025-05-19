<flux:modal name="administrator.user-management.permission.create.modal" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.edit_role') }} : {{ $role->name }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.edit_role_description') }}</flux:text>
        </div>
        <!-- Modal body -->
        <form wire:submit="edit" method="post">
            <div class="pb-2">
                <flux:field>
                    <flux:label>{{ __('jetadmin.name') }}</flux:label>

                    <flux:input wire:model="name" type="text" />

                    <flux:error name="name" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('jetadmin.guard_name') }}</flux:label>

                    <flux:input wire:model="guard_name" type="text" />

                    <flux:error name="guard_name" />
                </flux:field>
            </div>
            <button type="submit" class="btn-default btn-indigo w-full">
                {{ __('jetadmin.update') }}
            </button>
        </form>
    </div>
</flux:modal>
