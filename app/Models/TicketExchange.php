<?php

namespace App\Models;

use Database\Factories\TicketExchangeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketExchange extends Model
{
    /** @use HasFactory<TicketExchangeFactory> */
    use HasFactory;

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}
