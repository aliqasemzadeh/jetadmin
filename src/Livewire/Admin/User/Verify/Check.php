<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Admin\User\Verify;

use AliQasemzadeh\JetAdmin\Models\User;
use AliQasemzadeh\JetAdmin\Models\UserVerify;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Check extends Component
{
    use LivewireAlert;
    public $verify;
    public $first_name;
    public $last_name;
    public $national_code;
    public $birth_at;
    public $note;

    public function mount(UserVerify $verify_id)
    {
        $this->verify = UserVerify::findOrFail($verify_id);

        $this->first_name = $this->verify->first_name;
        $this->last_name = $this->verify->last_name;
        $this->national_code = $this->verify->national_code;
        $this->birth_at = $this->verify->birth_at;
        $this->note = $this->verify->note;
        $this->random_string = $this->verify->random_string;

    }
    public function accept()
    {
        $user = User::findOrFail($this->verify->user_id);
        $user->verified_at = Carbon::now();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->national_code = $this->national_code;
        $user->save();

        $this->verify->status = 'accept';
        $this->verify->save();

        $this->dispatch('admin.user.verify.index');
        $this->dispatch('hideModal');

        $this->alert('success', __('jetadmin::jetadmin.accepted'));
    }

    public function reject()
    {
        $this->verify->status = 'reject';
        $this->verify->save();

        $this->dispatch('admin.user.verify.index');
        $this->dispatch('hideModal');

        $this->alert('success', __('jetadmin::jetadmin.rejected'));
    }

    public function inquiry()
    {

    }

    public function render()
    {
        return view('jetadmin::livewire.admin.user.verify.check');
    }
}
