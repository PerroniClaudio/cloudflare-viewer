@extends('layouts.app')

@section('title', 'Connessioni R2')
@section('heading', 'Connessioni R2')
@section('subheading')
    <a href="{{ route('connections.create') }}" class="btn btn-primary btn-sm">
        <x-lucide-plus class="h-4 w-4" />
        Nuova connessione
    </a>
@endsection

@section('content')
    <div class="card bg-base-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Colore</th>
                        <th>Nome</th>
                        <th>Bucket</th>
                        <th>Endpoint</th>
                        <th class="text-right">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($connections as $connection)
                        <tr>
                            <td>
                                <div class="h-5 w-5 rounded-full border border-base-300" style="background-color: {{ $connection->color }};"></div>
                            </td>
                            <td class="font-medium">{{ $connection->name }}</td>
                            <td>{{ $connection->bucket }}</td>
                            <td>{{ $connection->endpoint }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('connections.browse', $connection) }}" class="btn btn-ghost btn-xs">
                                        <x-lucide-folder-open class="h-4 w-4" />
                                        Apri
                                    </a>
                                    <a href="{{ route('connections.edit', $connection) }}" class="btn btn-ghost btn-xs">
                                        <x-lucide-pencil class="h-4 w-4" />
                                        Modifica
                                    </a>
                                    <form action="{{ route('connections.destroy', $connection) }}" method="post" onsubmit="return confirm('Eliminare questa connessione?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-ghost btn-xs text-error">
                                            <x-lucide-trash-2 class="h-4 w-4" />
                                            Elimina
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center opacity-70">
                                Nessuna connessione configurata.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
