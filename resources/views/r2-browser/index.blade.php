@extends('layouts.app')

@section('title', $connection->name)
@section('heading')
    {{ $connection->name }}
@endsection

@section('subheading')
    <a href="{{ route('connections.index') }}" class="btn btn-ghost btn-sm">
        <x-lucide-settings class="h-4 w-4" />
        Gestisci connessioni
    </a>
@endsection

@section('content')
    <div class="grid gap-6 lg:grid-cols-[260px,1fr]">
        <aside class="card bg-base-100 shadow-sm p-4 h-fit">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold">Connessioni</h2>
                <a href="{{ route('connections.create') }}" class="btn btn-primary btn-xs">
                    <x-lucide-plus class="h-3 w-3" />
                    Nuova
                </a>
            </div>
            <ul class="menu menu-sm bg-base-100 rounded-box">
                @foreach ($connections as $item)
                    <li>
                        <a href="{{ route('connections.browse', $item) }}" class="{{ $item->is($connection) ? 'active' : '' }}">
                            <span class="h-2 w-2 rounded-full" style="background-color: {{ $item->color }};"></span>
                            <span class="truncate">{{ $item->name }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

        <section class="space-y-4">
            <div class="card bg-base-100 shadow-sm p-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="breadcrumbs text-sm">
                        <ul>
                            @foreach ($breadcrumbs as $crumb)
                                <li>
                                    <a href="{{ route('connections.browse', ['connection' => $connection, 'prefix' => $crumb['prefix']]) }}">{{ $crumb['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="text-xs opacity-70">{{ $connection->bucket }}</div>
                </div>

                @php
                    $queryBase = [
                        'prefix' => $prefix,
                        'sort' => $sort,
                        'direction' => $direction,
                    ];
                @endphp

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <form method="get" class="flex flex-wrap items-center gap-2">
                        <input type="hidden" name="prefix" value="{{ $prefix }}">
                        <input type="hidden" name="sort" value="{{ $sort }}">
                        <input type="hidden" name="direction" value="{{ $direction }}">
                        <input name="search" type="text" value="{{ $search }}" placeholder="Cerca per nome (prefix)" class="input input-bordered input-sm w-64">
                        <button class="btn btn-primary btn-sm" type="submit">
                            <x-lucide-search class="h-4 w-4" />
                            Cerca
                        </button>
                        @if ($search !== '')
                            <a href="{{ route('connections.browse', ['connection' => $connection, 'prefix' => $prefix, 'sort' => $sort, 'direction' => $direction]) }}" class="btn btn-ghost btn-sm">
                                <x-lucide-rotate-ccw class="h-4 w-4" />
                                Reset
                            </a>
                        @endif
                    </form>

                    @if ($prefix !== '')
                        @php
                            $parts = array_values(array_filter(explode('/', trim($prefix, '/'))));
                            array_pop($parts);
                            $parent = $parts === [] ? '' : implode('/', $parts).'/';
                        @endphp
                        <a href="{{ route('connections.browse', ['connection' => $connection, 'prefix' => $parent]) }}" class="btn btn-ghost btn-sm">
                            <x-lucide-arrow-up class="h-4 w-4" />
                            Cartella superiore
                        </a>
                    @endif
                </div>
            </div>

            <div class="card bg-base-100 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            @php
                                $nameDirection = $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc';
                                $sizeDirection = $sort === 'size' && $direction === 'asc' ? 'desc' : 'asc';
                                $modifiedDirection = $sort === 'modified' && $direction === 'asc' ? 'desc' : 'asc';
                            @endphp
                            <tr>
                                <th>Tipo</th>
                                <th>
                                    <a href="{{ route('connections.browse', array_merge($queryBase, ['connection' => $connection, 'sort' => 'name', 'direction' => $nameDirection])) }}">Nome</a>
                                </th>
                                <th>
                                    <a href="{{ route('connections.browse', array_merge($queryBase, ['connection' => $connection, 'sort' => 'size', 'direction' => $sizeDirection])) }}">Dimensione</a>
                                </th>
                                <th>
                                    <a href="{{ route('connections.browse', array_merge($queryBase, ['connection' => $connection, 'sort' => 'modified', 'direction' => $modifiedDirection])) }}">Ultima modifica</a>
                                </th>
                                <th class="text-right">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($directories as $directory)
                                <tr>
                                    <td>
                                        <span class="badge badge-outline">
                                            <x-lucide-folder class="h-3 w-3" />
                                            DIR
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('connections.browse', ['connection' => $connection, 'prefix' => $directory['prefix']]) }}" class="link link-hover">
                                            {{ $directory['name'] }}
                                        </a>
                                    </td>
                                    <td class="opacity-60">—</td>
                                    <td class="opacity-60">—</td>
                                    <td class="text-right">
                                        <a href="{{ route('connections.browse', ['connection' => $connection, 'prefix' => $directory['prefix']]) }}" class="btn btn-ghost btn-xs">
                                            <x-lucide-folder-open class="h-4 w-4" />
                                            Apri
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach ($files as $file)
                                <tr>
                                    <td>
                                        <span class="badge">
                                            <x-lucide-file class="h-3 w-3" />
                                            FILE
                                        </span>
                                    </td>
                                    <td class="font-medium">{{ $file['name'] }}</td>
                                    <td>{{ \Illuminate\Support\Number::fileSize($file['size']) }}</td>
                                    <td>{{ $file['modified']->format('Y-m-d H:i') }}</td>
                                    <td class="text-right">
                                        <a href="{{ route('connections.download', ['connection' => $connection, 'path' => $file['key']]) }}" class="btn btn-primary btn-xs">
                                            <x-lucide-download class="h-4 w-4" />
                                            Download
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($directories->isEmpty() && $files->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center opacity-70">Nessun elemento in questa cartella.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($nextToken)
                <div class="flex justify-end">
                    <a href="{{ route('connections.browse', array_merge($queryBase, ['connection' => $connection, 'token' => $nextToken, 'search' => $search])) }}" class="btn btn-outline">
                        <x-lucide-chevron-right class="h-4 w-4" />
                        Pagina successiva
                    </a>
                </div>
            @endif
        </section>
    </div>
@endsection
