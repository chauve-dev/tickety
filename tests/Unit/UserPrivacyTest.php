<?php

use App\Models\Ticket;
use App\Models\User;

uses(Tests\TestCase::class);

test('if ticket reference to user is redirected to anonymous if user is deleted', function () {
    // the anonymous user id is -1
    $anonyme = User::find(-1);

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $ticket = Ticket::factory()->create([
        'assignee' => $user1->id,
        'reporter' => $user2->id,
    ]);

    expect($ticket->assignee)->toBe($user1->id)
        ->and($ticket->reporter)->toBe($user2->id);

    $user1->delete();
    $ticket->refresh();

    expect($ticket->assignee)->toBe($anonyme->id)
        ->and($ticket->reporter)->toBe($user2->id);

    $user2->delete();
    $ticket->refresh();

    expect($ticket->assignee)->toBe($anonyme->id)
        ->and($ticket->reporter)->toBe($anonyme->id);
});
