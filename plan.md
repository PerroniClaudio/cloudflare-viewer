# Plan

## Obiettivo
Helper Laravel per visualizzare i bucket Cloudflare R2 con UI tipo file system.

## Requisiti confermati
- CRUD configurazioni in SQLite via UI (create/edit/delete).
- Campi configurazione: nome connessione, colore hex, access_key_id, secret_access_key, endpoint, bucket.
- Credenziali cifrate a riposo; decrypt per uso runtime.
- Nessuna autenticazione (uso locale).
- Navigazione bucket paginata (prefix + delimiter).
- Ricerca per nome; tabella con filtri quando ha senso.
- Download file (niente preview).
- UI: sidebar configurazioni + area browser con breadcrumb.
- Nessun “ultimo percorso visitato”.

## MVP (proposta)
1) Gestione configurazioni (CRUD + validazioni).
2) Browser bucket: lista “cartelle” (prefix) e file, paginata.
3) Ricerca per nome con filtro lato query.
4) Download file.

## Decisioni tecniche da definire
- SDK S3 compatibile: usare filesystem S3 driver nativo di Laravel.
- Schema DB (tabella `r2_connections` con cifratura).
- Strategia paginazione: max-keys + continuation token.
- Filtri tabella: nome, dimensione, data.
- Paginazione: 50 elementi per pagina.

## Prossimi passi
- Allineare scelta SDK e strategia di paginazione.
- Definire rotte, controller, form request e viste Blade.
- Definire UX dettagliata (breadcrumb, tabella, search, paginazione).
