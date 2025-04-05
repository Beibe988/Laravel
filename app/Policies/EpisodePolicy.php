<?php

namespace App\Policies;

use App\Models\Episode;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EpisodePolicy
{
    /**
     * Chiunque autenticato può vedere episodi.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Episode $episode): bool
    {
        return true;
    }

    /**
     * Solo Admin può creare nuovi episodi.
     */
    public function create(User $user): Response
    {
        return $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Solo gli amministratori possono aggiungere episodi.');
    }

    /**
     * Solo Admin può aggiornare episodi.
     */
    public function update(User $user, Episode $episode): Response
    {
        return $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Non hai il permesso per aggiornare questo episodio.');
    }

    /**
     * Solo Admin può eliminarli.
     */
    public function delete(User $user, Episode $episode): Response
    {
        return $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Non hai il permesso per eliminare questo episodio.');
    }
}
