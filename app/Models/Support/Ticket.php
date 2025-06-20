<?php

namespace App\Models\Support;

use App\Models\Setting\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function replays()
    {
        return $this->hasMany(TicketReplay::class, 'ticket_id', 'id');
    }

    public function files()
    {
        return $this->hasMany(TicketFile::class, 'ticket_id', 'id');
    }
}
