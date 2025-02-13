<?php

use App\Models\Ticket;
use App\Models\User;

uses(Tests\TestCase::class);

test('if ticket reference to user is redirected to anonymous if user is deleted', function () {
    // the anonymous user id is -1
    $anonyme = User::find(-1);

    $user = User::factory()->create();

    $ticket1 = Ticket::factory()->create([
        'assignee' => $user->id,
        'reporter' => $user->id,
    ]);

    $ticket2 = Ticket::factory()->create([
        'assignee' => $user->id,
        'reporter' => $user->id,
    ]);

    $user->delete();

    $ticket1->refresh();
    $ticket2->refresh();

    expect($ticket1->assignee)->toBe($anonyme->id)
        ->and($ticket1->reporter)->toBe($anonyme->id)
        ->and($ticket2->assignee)->toBe($anonyme->id)
        ->and($ticket2->reporter)->toBe($anonyme->id);
});
