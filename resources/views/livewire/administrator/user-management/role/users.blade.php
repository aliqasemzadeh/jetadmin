<flux:modal name="administrator.user-management.role.users.modal"  class="min-w-full min-h-full">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ __('jetadmin.users') }}: {{ $role->name }}</flux:heading>
            <flux:text class="mt-2">{{ __('jetadmin.role_users_description') }}</flux:text>
        </div>
        <div>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($role->users as $user)
                    <li class="pb-3 sm:pb-4">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $user->name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">

                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                <flux:button  wire:confirm="{{ __('system.are_you_sure') }}" wire:click="revoke('{{ $user->id  }}', '{{ $role->name }}')"><flux:icon.trash /></flux:button>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</flux:modal>
