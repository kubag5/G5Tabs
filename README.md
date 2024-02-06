# G5Tabs
* [do czego służy aplikacja?](#do-czego-służy-aplikacja)
* [jak będą działać zakładki?](#jak-będą-działać-zakładki)
* [kategorie zakładek](#kategorie-zakładek)
* [Dziennik zmian](#dziennik-zmian)

## do czego służy aplikacja?
Aplikacja będzie umożliwiać tworzenie użytkownikowi własnych zakładek.

## jak będą działać zakładki?
zakładki będą podstronami strony które będą zawierały różne informacje w zależności od typu zakładki. czyli zakładki to będą strony informacyjne utworzone przez użytkowników.

użytkownik będzie mógł wybrać czy zakładka ma być publiczna czy prywatna.

## Kategorie zakładek: 
<details>
<summary>Linia czasu</summary>
użytkownik w lini czasu może dodawać co się stało lub stanie w danym dniu. a następnie strona generuje daty oraz kafelki informacjami umieszczonymi przez użytkownika. (w planach jest interakcja z kafelkami)
</details>
<details>
<summary>Plan</summary>
użytkownik w planie może dodawać jakie ma plany na przyszłość. strona będzie wyświetlała liste z odliczaniem do każdego poszczególnego planu na przyszłość.
</details>
<br/>
nowe kategorie zakładek będą wymyślane z czasem. 

## Dziennik zmian

### 0.2.5.1
+ małe zmiany w kodzie

### 0.2.5
+ Zaaktualizowanie pliku SQL tak aby posiadał wszystkie tabele.
+ Dodano system wczytywania styli

### 0.2.4
+ naprawa błędu "ścieżki configu"
+ dodanie pliku sql

### 0.2.3
+ dodano config

### 0.2.2
+ System dodawania Tabów (Zakładek)
+ System usuwania Tabów (Zakładek)
+ System edytowania Tabów (Zakładek)
+ Kilka (dość sporo) mniejszych zmian.

### 0.2.1
+ System sesji
+ System wyświetlania zakładki "Linia czasu"
+ Załatanie wszystkich znalezionych błędów i dodatnie kilka innych mniejszych zmian

### 0.1.9
+ Załatanie błędu z bardzo długimi nazwami użytkowników. (wprowadzono ograniczenie 50 znaków).
+ Nowa animacja "borderu" od panelu logowania.

### 0.1.8
+ Interakcja "Login"
+ Interakcja "Rejestracja"
+ Mniejsze zmiany w pliku core.js

### 0.1.7
+ Wprowadzono **Dziennik zmian**
+ Rozpoczęto tworzenie menadżera akcji do zażądzania interaakcjami z poziomu serwera.
+ Inne mniejsze zmiany