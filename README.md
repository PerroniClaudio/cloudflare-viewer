# Cloudflare R2 Viewer

Helper Laravel per visualizzare il contenuto dei bucket Cloudflare R2. Consente di gestire più configurazioni (connessioni) salvate in SQLite e di navigare i bucket con un’interfaccia tipo file system (cartelle, file, download).

## Requisiti

- PHP (versione compatibile con il progetto)
- Composer
- Node.js + pnpm
- SQLite

## Setup locale

1. Installa le dipendenze PHP:

```
composer install
```

2. Crea il file ambiente:

```
cp .env.example .env
php artisan key:generate
```

3. Crea il database SQLite:

```
mkdir -p database
[ -f database/database.sqlite ] || touch database/database.sqlite
```

4. Aggiorna `.env` per usare SQLite:

```
DB_CONNECTION=sqlite
DB_DATABASE=/percorso/assoluto/al/progetto/database/database.sqlite
```

5. Esegui le migration:

```
php artisan migrate
```

6. Installa dipendenze frontend e avvia Vite:

```
npm install
npm run dev
```

## Avvio

Avvia l’app con Laravel Herd (automatico) oppure:

```
php artisan serve
```

## Configurare una nuova connessione R2

Vai su **Connessioni R2** e crea una nuova connessione inserendo:

- Nome connessione (a piacere)
- Colore in hex (es. `#ff00aa`)
- Access Key ID
- Secret Access Key
- Endpoint (es. `https://<account-id>.r2.cloudflarestorage.com`)
- Nome del bucket

Dopo il salvataggio, apri la connessione dalla lista per navigare cartelle e file.

## Funzionalità attuali

- CRUD connessioni R2 (SQLite)
- Browser del bucket con breadcrumb
- Ricerca per prefisso (nome)
- Ordinamento per nome, dimensione e data
- Download file

## Note

- La ricerca è basata su prefisso (limitazione del protocollo S3/R2).
- Per il download è necessario il driver S3 di Laravel e l’SDK AWS.
