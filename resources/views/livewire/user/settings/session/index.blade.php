
<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Session')" :subheading="__('Check your online sessions.')">
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @if (count($this->sessions) > 0)
                @foreach ($this->sessions as $session)
                    <li class="pb-3 sm:pb-4">
                        <div class="flex items-center space-x-4 rtl:space-x-reverse">
                            <div class="shrink-0">
                                @if ($session->agent->isDesktop())
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 rounded-full">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 rounded-full">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                    {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} - {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                </p>
                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ $session->ip_address }},

                                    @if ($session->is_current_device)
                                        <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                    @else
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    @endif
                                </p>
                            </div>
                            <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
        <flux:modal.trigger name="confirm-logout-others">
            <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-logout-others')">
                {{ __('Logout Other Devices') }}
            </flux:button>
        </flux:modal.trigger>
        <flux:modal name="confirm-logout-others" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
            <form wire:submit="logoutOthers" class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Are you sure you want to logout others?') }}</flux:heading>

                    <flux:subheading>
                        {{ __('After we remove all other session, Other devices not able to use this account.') }}
                    </flux:subheading>
                </div>

                <flux:input wire:model="password" id="password" :label="__('Password')" type="password" name="password" />

                <div class="flex justify-end space-x-2">
                    <flux:modal.close>
                        <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                    </flux:modal.close>

                    <flux:button variant="danger" type="submit">{{ __('Logout') }}</flux:button>
                </div>
            </form>
        </flux:modal>
    </x-settings.layout>
</section>
