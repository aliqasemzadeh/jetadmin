<div class="p-4 bg-white rounded-lg shadow dark:bg-zinc-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-zinc-600">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
            {{ __('jetadmin.users') }}: {{ $role->name }}
        </h3>
        <button wire:click="$dispatch('closeModal')" type="button" class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-zinc-600 dark:hover:text-white" data-modal-toggle="updateUserModal">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close modal</span>
        </button>
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

