@extends('layouts.app')

@section('title', 'Nuova connessione')
@section('heading', 'Nuova connessione')

@section('content')
    <form action="{{ route('connections.store') }}" method="post" class="space-y-6">
        @csrf

        <div class="card bg-base-100 shadow-sm p-6">
            @include('r2-connections._form', ['connection' => $connection])
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn btn-primary">
                <x-lucide-save class="h-4 w-4" />
                Salva
            </button>
            <a href="{{ route('connections.index') }}" class="btn btn-ghost">
                <x-lucide-x class="h-4 w-4" />
                Annulla
            </a>
        </div>
    </form>
@endsection
