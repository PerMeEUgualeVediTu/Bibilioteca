# Documentazione dei File relativi alla cartella 'biblio_login'

## Istruzioni per integrarli nel sito

### 0. Database
Creare un database e nominarlo "userform", come a riga 2 del file `connection.php`.  
Eseguire tutte le query del file `userform.sql`, file che poi può essere eliminato.

### 1. Da ignorare
- Cartella `vendor`
- File `composer.json`
- File `composer.lock`

Questi file sono stati installati con Composer per installare PHPMailer (https://github.com/PHPMailer/PHPMailer), il sistema adottato per mandare le email.

### 2. `home.php`
`home.php` è un esempio di pagina di area personale alla quale si accede solo dopo aver fatto il login; potrà quindi essere cancellata.  
**Attenzione!** Sostituire però le location nel `controllerUserData.php`, alle righe 173 e 178. (`home.php` -> "path della home del sito vero").  
Si può prendere spunto per copiare il bottone di logout (riga 65), che deve puntare al file `logout-user.php`.

### 3. `logout-user.php`
Questo file distrugge la sessione e rimanda ad una pagina a piacere. In questo caso, rimanda a `login-user.php`, ma consiglio di cambiarlo con la pagina home iniziale del sito.

### 4. Nella pagina iniziale del sito
Deve esserci presente un bottone "Login" o un bottone "Signup" (o entrambi, tanto da uno è poi possibile andare all'altro) che mandino rispettivamente ai file `login-user.php` e `signup-user.php`.

### 5. Mantenere la sessione attiva
È consigliato procedere nel seguente modo:

- **Nella pagina principale dell'area personale**:
  Copia e incolla le righe 1-23 del file `home.php`.

- **Nelle altre pagine dell'area personale**:
  All'inizio di ogni file, includi il seguente codice PHP per garantire che la sessione sia attiva e valida:

  ```php
  <?php
  require_once "controllerUserData.php"; 
  require_once "session-check.php"; 
  ?>

## Note

- **Controllo per utenti del Grigoletti**: È stato inserito un controllo per far registrare solo utenti del Grigoletti (file: `controllerUserData.php`, righe 25-28).

- **Verifica certificati SSL/TLS**: La verifica del certificato e del nome del certificato SSL/TLS del server è disabilitata (file: `controllerUserData.php`, righe 59-65, 238-244).

- **Hash sicuro delle password**: Viene creato un hash sicuro della password dell'utente utilizzando l'algoritmo bcrypt (file: `controllerUserData.php`, righe 36 e 366).

- **Codice monouso**: Il codice monouso è generato randomicamente sul momento (file: `controllerUserData.php`, righe 37 e 218).

- **Password dimenticata**: È presente la sezione per la password dimenticata.

- **Controlli e messaggi di errore**: Ci sono controlli vari e l'utente è sempre informato degli errori commessi (es. password/email errata, email non presente nel database, OTP sbagliato, ecc.).

- **Email in HTML/CSS**: Le email sono scritte usando HTML/CSS.

- **Contatti**: Per richieste, dubbi o domande, contattare: fabiofregolent27@gmail.com

