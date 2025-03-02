<?php

namespace App\Livewire\Administrator\UserManagement\Permission;

use Illuminate\Validation\Rule;
use LivewireUI\Modal\ModalComponent;
use Spatie\Permission\Models\Permission;

class Edit extends ModalComponent
{
    public Permission $permission;
    public string $name = '';
    public string $guard_name = 'web';

    public function mount($id)
    {
        $this->permission = Permission::findById($id);
        $this->name = $this->permission->name;
        $this->guard_name = $this->permission->guard_name;
    }

    public function edit()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($this->permission->id)],
            'guard_name' => ['required', 'string', 'max:255', 'in:web'],
        ]);

        $this->permission->update($validated);

        $this->dispatch('pg:eventRefresh-administrator.user-management.permission.index');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        $this->authorize('administrator_user_permission_edit');
        return view('livewire.administrator.user-management.permission.edit');
    }
}
