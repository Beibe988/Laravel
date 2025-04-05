<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EpisodeController extends Controller
{
    use AuthorizesRequests;

    // Visualizza tutti gli episodi
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'Admin') {
            return response()->json(Episode::all(), 200);
        }

        return response()->json(
            Episode::whereHas('serie', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get(),
            200
        );
    }

    // Visualizza un singolo episodio
    public function show($id)
    {
        $episode = Episode::find($id);

        if (!$episode) {
            return response()->json(['message' => 'Episodio non trovato'], 404);
        }

        return response()->json($episode, 200);
    }

    // Crea un nuovo episodio
    public function store(Request $request)
    {
        $this->authorize('create', \App\Models\Episode::class);

        $validated = $request->validate([
            'serie_tv_id' => 'required|exists:serie_tv,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'nullable|url|max:255',
        ]);

        $episode = Episode::create($validated);

        return response()->json(['message' => 'Episodio creato', 'episode' => $episode], 201);
    }

    // Aggiorna un episodio
    public function update(Request $request, $id)
    {
        $episode = Episode::find($id);

        if (!$episode) {
            return response()->json(['message' => 'Episodio non trovato'], 404);
        }

        $this->authorize('update', $episode);

        $validated = $request->validate([
            'serie_tv_id' => 'sometimes|exists:serie_tv,id',
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'video_url'   => 'nullable|url|max:255',
        ]);

        $episode->update($validated);

        return response()->json(['message' => 'Episodio aggiornato', 'episode' => $episode]);
    }

    // Elimina un episodio
    public function destroy($id)
    {
        $episode = Episode::find($id);

        if (!$episode) {
            return response()->json(['message' => 'Episodio non trovato'], 404);
        }

        $this->authorize('delete', $episode);

        $episode->delete();

        return response()->json(['message' => 'Episodio eliminato con successo']);
    }
}



