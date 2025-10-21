<?php

namespace App\Observers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Check if the 'username' field was changed
        if ($user->isDirty('username')) {
            // Get the original username before the update
            $originalUsername = $user->getOriginal('username');

            // Find the pegawai with the old username as their NIP
            $pegawai = Pegawai::where('nip', $originalUsername)->first();

            // If a pegawai is found, update their NIP to the new username
            if ($pegawai) {
                $pegawai->nip = $user->username;
                $pegawai->save();
            }
        }
    }
}
