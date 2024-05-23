# Gestione Magazzino

Questa è una webapp per la gestione del magazzino. Include funzionalità di inserimento, modifica e visualizzazione dei prodotti con autenticazione degli utenti.

## Requisiti

- PHP 7.x o superiore
- MySQL
- Apache Server

## Installazione

1. Clona il repository.
2. Configura il database e aggiorna `includes/config.php` con le tue credenziali.
3. Crea le tabelle nel database usando lo script SQL fornito.
4. Avvia il server web e accedi alla webapp.

## Utilizzo

- Admin può aggiungere, modificare e cancellare prodotti.
- Gli utenti normali possono visualizzare la lista dei prodotti.

## Struttura del Progetto

- `assets/`: Contiene CSS, JS e immagini.
- `includes/`: Contiene configurazioni comuni e parti di layout.
- `admin/`: Contiene pagine di gestione prodotti riservate agli admin.
- `auth/`: Contiene pagine di login e logout.
- `api/`: Contiene script per l'API.
