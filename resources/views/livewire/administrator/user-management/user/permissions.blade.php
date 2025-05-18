<flux:modal name="administrator.user-management.user.permissions.modal" class="md:w-96">
    <div class="space-y-6">
    <div>
        <flux:heading size="lg">{{ __('jetadmin.permissions') }}: {{ $user->name }}</flux:heading>
        <flux:text class="mt-2">{{ __('jetadmin.roles_description') }}</flux:text>
    </div>


    <div class="grid grid-cols-2 gap-4">
        <div>
            <flux:field>
                <flux:field>
                    <flux:label>{{ __('jetadmin.search') }}</flux:label>
                    <flux:input wire:model.live="search" type="text" />
                    <flux:error name="search" />
                </flux:field>
            </flux:field>

            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($permissions as $permission)
                    <li class="pb-3 sm:pb-4">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $permission->name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">

                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <flux:button wire:click="assign({{ $permission->id }})" wire:confirm="{{ __('jetadmin.are_you_sure') }}"><flux:icon.plus-circle /></flux:button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>


        </div>

        <div>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($user->permissions as $permission)
                    <li class="pb-3 sm:pb-4">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $permission->name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">

                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <flux:button wire:click="delete({{ $permission->id }})" wire:confirm="{{ __('jetadmin.are_you_sure') }}"><flux:icon.trash /></flux:button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    </div>

</flux:modal>

