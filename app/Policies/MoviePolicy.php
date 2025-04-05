<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MoviePolicy
{
    /**
     * Qualsiasi utente autenticato può vedere la lista dei film.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Qualsiasi utente autenticato può vedere i dettagli del film.
     */
    public function view(User $user, Movie $movie): bool
    {
        return true;
    }

    /**
     * Solo gli Admin possono creare film.
     */
    public function create(User $user): Response
    {
        return $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Solo gli amministratori possono creare nuovi film.');
    }

    /**
     * Gli Admin e i creatori possono aggiornare i film.
     */
    public function update(User $user, Movie $movie): Response
    {
        return ($user->role === 'Admin' || $user->id === $movie->user_id)
            ? Response::allow()
            : Response::deny('Non hai i permessi per aggiornare questo film.');
    }

    /**
     * Gli Admin e i creatori possono eliminare i film.
     */
    public function delete(User $user, Movie $movie): Response
    {
        return ($user->role === 'Admin' || $user->id === $movie->user_id)
            ? Response::allow()
            : Response::deny('Non hai i permessi per eliminare questo film.');
    }

    /**
     * Solo Admin può ripristinare film eliminati.
     */
    public function restore(User $user, Movie $movie): Response
    {
        return $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Non hai i permessi per ripristinare questo film.');
    }

    /**
     * Solo Admin può eliminare definitivamente un film.
     */
    public function forceDelete(User $user, Movie $movie): Response
    {
        return $user->role === 'Admin'
            ? Response::allow()
            : Response::deny('Non hai i permessi per eliminare definitivamente questo film.');
    }
}


