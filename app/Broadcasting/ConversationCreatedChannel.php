<?php

namespace App\Broadcasting;

use App\User;

class ConversationCreatedChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\User  $user
     * @return array|bool
     */
    public function join(User $user, $id)
    {
        return $user->id == $id;
    }
}
