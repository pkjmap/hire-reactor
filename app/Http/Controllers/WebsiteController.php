<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    /**
     * List websites for a client
     */
    public function index(Client $client)
    {
        return $client->websites()
            ->select('id', 'url')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Store website (max 10 per client)
     */
    public function store(Request $request, Client $client)
    {
        if ($client->websites()->count() >= 10) {
            return response()->json([
                'message' => 'A client can monitor a maximum of 10 websites.'
            ], 422);
        }

        $validated = $request->validate([
            'url' => ['required', 'url', 'max:2048'],
        ]);

        $website = $client->websites()->create($validated);

        return response()->json([
            'message' => 'Website added successfully',
            'website' => $website,
        ], 201);
    }
}
