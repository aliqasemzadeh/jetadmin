<div class="p-4 bg-white rounded-lg shadow dark:bg-zinc-800 sm:p-5">
    <!-- Modal header -->
    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-zinc-600">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
            {{ __('jetadmin.edit_role') }} : {{ $role->name }}
        </h3>
        <button wire:click="$dispatch('closeModal')" type="button" class="text-zinc-400 bg-transparent hover:bg-zinc-200 hover:text-zinc-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-zinc-600 dark:hover:text-white" data-modal-toggle="updateUserModal">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close modal</span>
        </button>
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

