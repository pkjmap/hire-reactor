<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * List all clients
     */
    public function index()
    {
        return Client::select('id', 'email')->orderBy('email')->get();
    }

    /**
     * Store a new client email
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:clients,email'],
        ]);

        $client = Client::create($validated);

        return response()->json([
            'message' => 'Client added successfully',
            'client' => $client,
        ], 201);
    }
}

