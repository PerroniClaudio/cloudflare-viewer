<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrowseR2Request;
use App\Http\Requests\DownloadR2Request;
use App\Models\R2Connection;
use Aws\S3\S3Client;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class R2BrowserController extends Controller
{
    public function index(BrowseR2Request $request, R2Connection $connection): View
    {
        $prefix = $this->normalizePrefix($request->validated('prefix'));
        $search = $this->normalizeSearch($request->validated('search'));
        $token = $request->validated('token');
        $sort = $request->validated('sort', 'name');
        $direction = $request->validated('direction', 'asc');

        $client = $this->makeClient($connection);
        $requestPrefix = $search === '' ? $prefix : $prefix.$search;

        $options = [
            'Bucket' => $connection->bucket,
            'Delimiter' => '/',
            'MaxKeys' => 50,
        ];

        if ($requestPrefix !== '') {
            $options['Prefix'] = $requestPrefix;
        }

        if ($token) {
            $options['ContinuationToken'] = $token;
        }

        $result = $client->listObjectsV2($options);

        $directories = collect($result['CommonPrefixes'] ?? [])
            ->map(fn (array $item): array => [
                'name' => $this->extractName($item['Prefix'], $prefix),
                'prefix' => $item['Prefix'],
            ])
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        $files = collect($result['Contents'] ?? [])
            ->filter(fn (array $item): bool => $item['Key'] !== $prefix)
            ->map(fn (array $item): array => [
                'name' => $this->extractName($item['Key'], $prefix),
                'key' => $item['Key'],
                'size' => (int) $item['Size'],
                'modified' => $item['LastModified'],
            ])
            ->values();

        $files = $this->sortFiles($files, $sort, $direction);

        return view('r2-browser.index', [
            'connection' => $connection,
            'connections' => R2Connection::query()->orderBy('name')->get(),
            'breadcrumbs' => $this->buildBreadcrumbs($connection, $prefix),
            'prefix' => $prefix,
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
            'directories' => $directories,
            'files' => $files,
            'nextToken' => $result['NextContinuationToken'] ?? null,
        ]);
    }

    public function download(DownloadR2Request $request, R2Connection $connection): HttpResponse
    {
        $path = $request->validated('path');
        $disk = Storage::build($this->filesystemConfig($connection));

        return $disk->download($path);
    }

    private function makeClient(R2Connection $connection): S3Client
    {
        return new S3Client([
            'version' => 'latest',
            'region' => 'auto',
            'endpoint' => $connection->endpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $connection->access_key_id,
                'secret' => $connection->secret_access_key,
            ],
        ]);
    }

    private function filesystemConfig(R2Connection $connection): array
    {
        return [
            'driver' => 's3',
            'key' => $connection->access_key_id,
            'secret' => $connection->secret_access_key,
            'region' => 'auto',
            'bucket' => $connection->bucket,
            'endpoint' => $connection->endpoint,
            'use_path_style_endpoint' => true,
            'throw' => true,
        ];
    }

    private function normalizePrefix(?string $prefix): string
    {
        $prefix = trim((string) $prefix);

        if ($prefix === '') {
            return '';
        }

        $prefix = ltrim($prefix, '/');

        if (! str_ends_with($prefix, '/')) {
            $prefix .= '/';
        }

        return $prefix;
    }

    private function normalizeSearch(?string $search): string
    {
        return trim((string) $search);
    }

    private function extractName(string $path, string $prefix): string
    {
        $name = $prefix === '' ? $path : str_replace($prefix, '', $path);

        return trim($name, '/');
    }

    private function buildBreadcrumbs(R2Connection $connection, string $prefix): array
    {
        if ($prefix === '') {
            return [
                ['label' => $connection->bucket, 'prefix' => ''],
            ];
        }

        $parts = array_values(array_filter(explode('/', trim($prefix, '/'))));
        $crumbs = [
            ['label' => $connection->bucket, 'prefix' => ''],
        ];
        $current = '';

        foreach ($parts as $part) {
            $current .= $part.'/';
            $crumbs[] = [
                'label' => $part,
                'prefix' => $current,
            ];
        }

        return $crumbs;
    }

    private function sortFiles(Collection $files, string $sort, string $direction): Collection
    {
        $sorted = match ($sort) {
            'size' => $files->sortBy('size'),
            'modified' => $files->sortBy('modified'),
            default => $files->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE),
        };

        return $direction === 'desc' ? $sorted->reverse()->values() : $sorted->values();
    }
}
