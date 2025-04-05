<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SerieTv;
use Illuminate\Auth\Access\Response;

class SerieTvPolicy
{
    /**
     * Chi può vedere tutte le serie TV
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['User', 'Admin']);
    }

    /**
     * Chi può vedere una singola serie
     */
    public function view(User $user, SerieTv $serieTv): bool
    {
        return $user->id === $serieTv->user_id || $user->role === 'Admin';
    }

    /**
     * Chi può creare nuove serie
     */
    public function create(User $user): Response
    {
        return $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Solo gli amministratori possono aggiungere serie TV.');
    }

    /**
     * Chi può aggiornare una serie
     */
    public function update(User $user, SerieTv $serieTv): Response
    {
        return $user->id === $serieTv->user_id || $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Non hai i permessi per aggiornare questa serie.');
    }

    /**
     * Chi può eliminare una serie
     */
    public function delete(User $user, SerieTv $serieTv): Response
    {
        return $user->id === $serieTv->user_id || $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Non hai i permessi per eliminare questa serie.');
    }
}
