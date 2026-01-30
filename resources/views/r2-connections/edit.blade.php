@extends('layouts.app')

@section('title', 'Modifica connessione')
@section('heading', 'Modifica connessione')

@section('content')
    <form action="{{ route('connections.update', $connection) }}" method="post" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="card bg-base-100 shadow-sm p-6">
            @include('r2-connections._form', ['connection' => $connection])
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <x-lucide-save class="h-4 w-4" />
                Aggiorna
            </button>
            <a href="{{ route('connections.index') }}" class="btn btn-ghost">
                <x-lucide-x class="h-4 w-4" />
                Annulla
            </a>
        </div>
    </form>
@endsection
