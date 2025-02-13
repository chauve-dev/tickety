<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee');
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter');
    }

}
