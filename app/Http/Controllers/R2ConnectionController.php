<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreR2ConnectionRequest;
use App\Http\Requests\UpdateR2ConnectionRequest;
use App\Models\R2Connection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class R2ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('r2-connections.index', [
            'connections' => R2Connection::query()->orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('r2-connections.create', [
            'connection' => new R2Connection,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreR2ConnectionRequest $request): RedirectResponse
    {
        R2Connection::query()->create($request->validated());

        return to_route('connections.index')
            ->with('status', 'Connessione creata.');
    }

    /**
     * Display the specified resource.
     */
    public function show(R2Connection $connection): RedirectResponse
    {
        return to_route('connections.edit', $connection);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(R2Connection $connection): View
    {
        return view('r2-connections.edit', [
            'connection' => $connection,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateR2ConnectionRequest $request, R2Connection $connection): RedirectResponse
    {
        $connection->update($request->validated());

        return to_route('connections.index')
            ->with('status', 'Connessione aggiornata.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(R2Connection $connection): RedirectResponse
    {
        $connection->delete();

        return to_route('connections.index')
            ->with('status', 'Connessione eliminata.');
    }
}
