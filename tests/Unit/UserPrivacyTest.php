<?php

use App\Models\Ticket;
use App\Models\User;
use App\TicketExchangeType;

uses(Tests\TestCase::class);

test('if ticket reference to user is redirected to anonymous if user is deleted', function () {
    // the anonymous user id is -1
    $anonymous = User::find(-1);

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $ticket = Ticket::factory()->create([
        'assignee' => $user1,
        'reporter' => $user2,
    ]);

    expect($ticket->assignee)->toBe($user1->id)
        ->and($ticket->reporter)->toBe($user2->id);

    $user1->delete();
    $ticket->refresh();

    expect($ticket->assignee)->toBe($anonymous->id)
        ->and($ticket->reporter)->toBe($user2->id);

    $user2->delete();
    $ticket->refresh();

    expect($ticket->assignee)->toBe($anonymous->id)
        ->and($ticket->reporter)->toBe($anonymous->id);
});

test('if ticket exchanges get correct user if deleted', function () {
    // the anonymous user id is -1
    $anonymous = User::find(-1);

    $user = User::factory()->create()->refresh();
    $commenter = User::factory()->create()->refresh();

    expect($user->id)->not->toBe(-1)
        ->and($commenter->id)->not->toBe(-1);

    $ticket = Ticket::factory()->create(['reporter' => $user->id]);

    $exchange_commenter = $ticket->exchanges()->create([
        'user_id' => $commenter->id,
        'type' => TicketExchangeType::COMMENT,
        'exchange' => 'I have a problem with this ticket.',
    ]);

    $exchange_user = $ticket->exchanges()->create([
        'user_id' => $user->id,
        'type' => TicketExchangeType::COMMENT,
        'exchange' => 'What is the problem?.',
    ]);

    expect($exchange_commenter->user->id)->toBe($commenter->id)
        ->and($exchange_user->user->id)->toBe($user->id);

    $commenter->delete();

    $exchange_commenter->refresh();

    // the exchange is correctly wiped of original user info on deletion
    expect($exchange_commenter->user->id)->toBe($anonymous->id)
        ->and($exchange_user->user->id)->toBe($user->id);
});
