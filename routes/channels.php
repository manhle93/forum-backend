<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('likeChannel', function () {
   return true;
});

Broadcast::channel('Notification', function () {
    return true;
});

Broadcast::channel('tinnhan', function () {
    return true;
});