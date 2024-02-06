<?php

namespace AliQasemzadeh\JetAdmin\Livewire\Panel\User\Wallet;

use App\Http\Livewire\Panel\User\Wallet\UserWallet;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $userWallets = UserWallet::where('user_id', auth()->user()->id)->get();
        return view('jetadmin::livewire.panel.user.wallet.index', compact('userWallets'))->layout('layouts.panel');
    }
}
