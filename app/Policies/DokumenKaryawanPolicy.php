<?php

namespace App\Policies;

use App\Models\DokumenKaryawan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DokumenKaryawanPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role === 'superadmin') {
            return true;
        }
    }

    public function update(User $user, DokumenKaryawan $dokumenKaryawan)
    {
        return $user->pegawai->id === $dokumenKaryawan->pegawai_id;
    }

    public function delete(User $user, DokumenKaryawan $dokumenKaryawan)
    {
        return $user->pegawai->id === $dokumenKaryawan->pegawai_id;
    }
}
