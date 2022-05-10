# Progetto-PHP-e-MySQL-di-Vincent-Legnani

Ciao! Questo è il mio progetto PHP e MySQL,
troverai un programma che ti permette di creare, eliminare, aggiornare e leggere prodotti
(aventi 3 caratteristiche: id, nome e kg di plastica riciclati nella produzione),
ma anche di creare, eliminare, aggiornare e leggere gli ordini contenenti quei prodotti ( con un id ordine, la data in cui è effettuato, il nome del prodotto
e la quantità con cui è stato acquistato). 


Come utilizzarlo praticamente: 
innanzitutto servirà l'installazione di due software + uno extra: 
1) XAMPP https://www.apachefriends.org/it/index.html
( o uno simile) che creerà le connessioni server Apache e MySQL che permetteranno: la prima di interagire con il php, mentre la seconda di modificare 
e accedere direttamente al database;

2) Il secondo software è Postman https://www.postman.com/ (non è necessario fare il login)
permetterà di effettuare chiamate CRUD sopracitate. 

5) Il software extra è MySQL workbench https://www.mysql.com/it/products/workbench/
oppure anche phpmyadmin per operare sul database contenente i prodotti (nella tabella Products) e gli ordini (nella tabella Orders).

Innanzitutto avviate XAMPP e aprite i server Apache e MySQL, dopodichè aprite postman e vi lascio la legenda per fare le chiamate (per effettuare le chiamate, a meno che
non sia la chiamata read, dovrete scrivere un json). Prima di mandare settate postman, selezionate "body", "ray" e nel menù a tendina "JSON"

ultimo passo è configurare mysql e importare ("server" "data import") il file migrations.sql che contiene un database con all'interno già dei valori!

E adesso siete pronti per iniziare!

👶Per creare un prodotto: http://localhost://Progetto_PHP_e_MySQL_di_Vincent_Legnani/product-create, usando la funzione POST
e dovrete scrivere nel body {"name":"Nome del prodotto che volete creare", "kg_riciclati":numero dei kilogrammi riciclati NON TRA VIRGOLETTE)}
premete il tasto SEND (o ctrl+invio) e se avrete successo apparirà un messaggio con scritto "Response": "prodotto creato correttamente";

❌ per cancellare un prodotto: http://localhost://Progetto_PHP_e_MySQL_di_Vincent_Legnani/product-delete, usando la funzione DELETE
dovrete scrivere nel body {"id":codice id* del prodotto che si vuole eliminare NON TRA VIRGOLETTE)} 
*id è una primary key auto incrementante, quindi non dovrete/potrete modificarla voi stessi, verrà fornita dallo stesso mySQL ogni volta che creerete un prodotto,
per verificare quale prodotto ha qale id, leggere la funzione read.

premete il tasto SEND e se avrete successo apparirà un messaggio con scritto "Response": "Il prodotto è stato eliminato correttamente";

☁ per aggiornare un prodotto: http://localhost://Progetto_PHP_e_MySQL_di_Vincent_Legnani/product-update, usando la funzione POST
dovrete scrivere nel body {"id": codice id del prodotto che si vuole eliminare senza virgolette, "name":"Nuovo nome del prodotto",
"kg_riciclati":nuovo numero dei kilogrammi riciclati NON TRA VIRGOLETTE)}
premete il tasto SEND (o ctrl+invio) e se avrete successo apparirà un messaggio con scritto "Response": "prodotto aggiornato con successo";


📖 Per leggere tutti i prodotti: http://localhost://Progetto_PHP_e_MySQL_di_Vincent_Legnani/product-read, usando la funzione GET 
per leggere l'elenco dei prodotti non dovrete scrivere nulla nel body, basta premere SEND e vi restituirà il file json contenente tutti i prodotti, con relativo id
e i kilogrammi di plastica riciclata. 


Questo per quanto riguarda i prodotti. Visto che l'applicazione simula un' ecommerce è possibile effettuare ordini, ecco come: 

👶Per creare un ordine:http://localhost/Progetto_PHP_e_MySQL_di_Vincent_Legnani/order-create, usando la funzione POST
e dovrete scrivere nel body 
{"id_order":"codice dell'ordine, può essere sia numerico che alfanumerico",
"products":"Nome del prodotto che si vuole aggiungere all'ordine", "products_quantity":numero dei prodotti da aggiungere all'ordine NON TRA VIRGOLETTE)}
premete il tasto SEND (o ctrl+invio) e se avrete successo apparirà un messaggio con scritto "Response": "ordine creato correttamente";


❌ Per cancellare un ordine:http://localhost/Progetto_PHP_e_MySQL_di_Vincent_Legnani/order-create, usando la funzione DELETE
e dovrete scrivere nel body 
{"id_order":"codice dell'ordine, può essere sia numerico che alfanumerico"}
premete il tasto SEND (o ctrl+invio) e se avrete successo apparirà un messaggio con scritto "Response": "l'ordine è stato eliminato";


☁ Per aggiornare un ordine:http://localhost/Progetto_PHP_e_MySQL_di_Vincent_Legnani/order-create, usando la funzione POST
e dovrete scrivere nel body 
{"id_order":"codice dell'ordine, può essere sia numerico che alfanumerico",
"products":"Nome del prodotto che si vuole aggiornare", "products_quantity":numero dei prodotti da aggiungere all'ordine aggiornato NON TRA VIRGOLETTE)}
premete il tasto SEND (o ctrl+invio) e se avrete successo apparirà un messaggio con scritto "Response": "ordine aggiornato con successo";


📖 Per leggere l'elenco degli ordini :http://localhost/Progetto_PHP_e_MySQL_di_Vincent_Legnani/order-create, usando la funzione GET
per leggere l'elenco degli ordini non dovrete scrivere nulla nel body, basta premere SEND e vi restituirà il file json contenente tutti gli ordini.

poi ci sono 3 funzioni extra:

1)🦸‍♂️Filtra ordini per prodotto, permette di vedere tutti gli ordini che contengono il prodotto cercato, 
http://localhost/Progetto_PHP_e_MySQL_di_Vincent_Legnani/filter-x-product usando la funzione GET
e dovrete scrivere {"product_searched":"nome del prodotto che state cercando"}


2)🦸‍♂️Filtra ordini per range di date: questo permette di cercare tutti gli ordini eseguiti tra due date:
http://localhost/Progetto_PHP_e_MySQL_di_Vincent_Legnani/filter-x-date usando la funzione GET
e dovrete scrivere nel body: {"start_date":20010101, "end_date":20220510}, quelli riportati sono due esempi, mysql riconosce il formato data tutto attaccato
partendo dall'anno (2022) poi il mese (05) e infine il giorno (10), si può rendere più precisa la ricerca attaccando in coda alla data anche l'ora, i minuti e i secondi
ad esempio: {"start_date":20030522182419, "end_date":20030522182421}

3)🦸‍♂️Quest'ultima funzionalità permette di ottenere la quantità totale di kilogrammi riciclati per ogni ordine effettuato:
http://localhost/Progetto_PHP_e_MySQL_di_Vincent_Legnani/kg-tot usando sempre la funzione GET, e senza scrivere nulla nel body.
