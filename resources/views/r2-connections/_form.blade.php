<div class="grid gap-6">
    <div class="form-control">
        <label for="name" class="label">
            <span class="label-text">Nome connessione</span>
        </label>
        <input id="name" name="name" type="text" class="input input-bordered w-full" value="{{ old('name', $connection->name) }}" required>
    </div>

    <div class="form-control">
        <label for="color" class="label">
            <span class="label-text">Colore (hex)</span>
        </label>
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-lg border border-base-300" style="background-color: {{ old('color', $connection->color ?? '#000000') }};"></div>
            <input id="color" name="color" type="text" class="input input-bordered w-full" value="{{ old('color', $connection->color ?? '#000000') }}" placeholder="#ff00aa" required>
        </div>
        <p class="text-xs opacity-70">Usa un valore esadecimale valido.</p>
    </div>

    <div class="form-control">
        <label for="access_key_id" class="label">
            <span class="label-text">Access Key ID</span>
        </label>
        <input id="access_key_id" name="access_key_id" type="text" class="input input-bordered w-full" value="{{ old('access_key_id', $connection->access_key_id) }}" required>
    </div>

    <div class="form-control">
        <label for="secret_access_key" class="label">
            <span class="label-text">Secret Access Key</span>
        </label>
        <input id="secret_access_key" name="secret_access_key" type="password" class="input input-bordered w-full" value="{{ old('secret_access_key', $connection->secret_access_key) }}" required>
    </div>

    <div class="form-control">
        <label for="endpoint" class="label">
            <span class="label-text">Endpoint</span>
        </label>
        <input id="endpoint" name="endpoint" type="url" class="input input-bordered w-full" value="{{ old('endpoint', $connection->endpoint) }}" placeholder="https://<account-id>.r2.cloudflarestorage.com" required>
    </div>

    <div class="form-control">
        <label for="bucket" class="label">
            <span class="label-text">Bucket</span>
        </label>
        <input id="bucket" name="bucket" type="text" class="input input-bordered w-full" value="{{ old('bucket', $connection->bucket) }}" required>
    </div>
</div>
