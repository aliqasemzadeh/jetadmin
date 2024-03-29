<?php

namespace AliQasemzadeh\JetAdmin\Exports;

use AliQasemzadeh\JetAdmin\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    public $users = [];

    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return User::query()->whereIn('id', $this->users)->get();
    }
}
