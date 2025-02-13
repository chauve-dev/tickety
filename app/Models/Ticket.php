<?php

namespace App\Models;

use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    /** @use HasFactory<TicketFactory> */
    use HasFactory;

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee');
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reporter');
    }

    public function exchanges(): HasMany
    {
        return $this->hasMany(TicketExchange::class);
    }

}
