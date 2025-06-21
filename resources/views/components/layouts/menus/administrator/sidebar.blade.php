<a href="{{ route('administrator.dashboard.index') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
    <x-app-logo />
</a>

<flux:navlist variant="outline">
    @can('administrator_dashboard_index')
        <flux:navlist.group heading="{{ __('jetadmin.panels.administrator') }}" class="grid">
            <flux:navlist.item icon="home" :href="route('administrator.dashboard.index')" :current="request()->routeIs('administrator.dashboard.index')" wire:navigate>{{ __('jetadmin.dashboard') }}</flux:navlist.item>
        </flux:navlist.group>
    @endcan

    @can('administrator_user_management')
        <flux:navlist.group heading="{{ __('jetadmin.user_management') }}" class="grid">
            @can('administrator_user_index')
                <flux:navlist.item icon="user-group" :href="route('administrator.user-management.user.index')" :current="request()->routeIs('administrator.user-management.user.index')" wire:navigate>{{ __('jetadmin.users') }}</flux:navlist.item>
            @endcan
            @can('administrator_user_role_index')
                <flux:navlist.item icon="user-circle" :href="route('administrator.user-management.role.index')" :current="request()->routeIs('administrator.user-management.role.index')" wire:navigate>{{ __('jetadmin.roles') }}</flux:navlist.item>
            @endcan
            @can('administrator_user_permission_index')
                <flux:navlist.item icon="adjustments-vertical" :href="route('administrator.user-management.permission.index')" :current="request()->routeIs('administrator.user-management.permission.index')" wire:navigate>{{ __('jetadmin.permissions') }}</flux:navlist.item>
            @endcan
        </flux:navlist.group>
    @endcan
        @can('administrator_content_management')
            <flux:navlist.group heading="{{ __('jetadmin.content_management') }}" class="grid">
                @can('administrator_content_article_index')
                    <flux:navlist.item icon="document-duplicate" :href="route('administrator.content-management.article.index')" :current="request()->routeIs('administrator.content-management.article.index')" wire:navigate>{{ __('jetadmin.articles') }}</flux:navlist.item>
                @endcan
                @can('administrator_content_faq_index')
                    <flux:navlist.item icon="question-mark-circle" :href="route('administrator.content-management.faq.index')" :current="request()->routeIs('administrator.content-management.faq.index')" wire:navigate>{{ __('jetadmin.faqs') }}</flux:navlist.item>
                @endcan
            </flux:navlist.group>
        @endcan
        @can('administrator_support_management')
            <flux:navlist.group heading="{{ __('jetadmin.support_management') }}" class="grid">
                @can('administrator_support_ticket_index')
                    <flux:navlist.item icon="rectangle-group" :href="route('administrator.support-management.ticket.index')" :current="request()->routeIs('administrator.support-management.*')" wire:navigate>{{ __('jetadmin.tickets') }}</flux:navlist.item>
                @endcan
            </flux:navlist.group>
        @endcan
        @can('administrator_setting_management')
            <flux:navlist.group heading="{{ __('jetadmin.setting_management') }}" class="grid">
                @can('administrator_setting_category_index')
                    <flux:navlist.item icon="rectangle-group" :href="route('administrator.setting-management.category.index')" :current="request()->routeIs('administrator.setting-management.category.index')" wire:navigate>{{ __('jetadmin.categories') }}</flux:navlist.item>
                @endcan
            </flux:navlist.group>
        @endcan
</flux:navlist>
