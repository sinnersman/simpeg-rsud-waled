<?php

namespace App\Observers;

use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PegawaiObserver
{
    /**
     * Handle the Pegawai "updated" event.
     */
    public function updated(Pegawai $pegawai): void
    {
        // Check if the 'nip' field was changed
        if ($pegawai->isDirty('nip')) {
            Log::info('Pegawai NIP changed. Original: ' . $pegawai->getOriginal('nip') . ', New: ' . $pegawai->nip);
            // Get the original NIP before the update
            $originalNip = $pegawai->getOriginal('nip');

            // Find the user with the old NIP as their username
            $user = User::where('username', $originalNip)->first();

            // If a user is found, update their username to the new NIP
            if ($user) {
                $user->username = $pegawai->nip;
                $user->save();
            }
        }
    }
}