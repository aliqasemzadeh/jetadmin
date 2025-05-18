<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public Role $role;
    public string $name = '';
    public string $guard_name = 'web';

    public function mount($id)
    {
        $this->role = Role::findById($id);
        $this->name = $this->role->name;
        $this->guard_name = $this->role->guard_name;
    }

    public function edit()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->role->id)],
            'guard_name' => ['required', 'string', 'max:255', 'in:web'],
        ]);

        $this->role->update($validated);

        $this->dispatch('pg:eventRefresh-administrator.user-management.role.index');
        $this->dispatch('closeModal');

    }

    public function render()
    {
        $this->authorize('administrator_user_role_edit');
        return view('livewire.administrator.user-management.role.edit');
    }
}
