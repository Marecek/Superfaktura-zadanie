* 1. algoritmická na zahriatie * 
Napíšte algoritmus, ktorý bude iterovať celé čísla od 1 do 100 a:
- ak je číslo deliteľné 3, vypíše na riadku "Super"
- ak je číslo deliteľné 5, vypíše na riadku "Faktura"
- ak je číslo deliteľné 15, vypíše "SuperFaktura"
- ak nesplilo žiadnu z týchto podmienok, vypíše číslo samotné.

* 2. databázová. *

Máte jednoduchú tabuľku s primárnym kľúčom a hodnotou v druhom stĺpci. Niektoré z týchto hodnôt môžu byť duplicitné. Napíšte prosím SQL query, ktorá vráti všetky riadky z tabuľky s duplicitnými hodnotami (*celé* riadky).

Definícia tabuľky a vzorové dáta:
CREATE TABLE `duplicates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `duplicates` (`id`, `value`) VALUES
(1,    1),
(2,    2),
(3,    3),
(4,    2),
(5,    4),
(6,    4),
(7,    5),
(8,    6),
(9,    6),
(10,    2);


Bude vaše riešenie efektívne fungovať aj na tabuľke s veľkým počtom riadkov (milión a viac)? Vysvetlite prečo a ako.

* 3. PHP * 
Napíšte prosím jednoduchú knižnicu (libku, ucelený blok kódu) na načítanie údajov firiem z českého registra spoločností. Nie je potrebné vytvárať používateľské rozhranie.

Vstupom metódy pre prácu s dátami má byť IČO. Formát výstupu metódy necháme na vás.

Endpoint pre údaje je https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/{ICO} príklad volania https://ares.gov.cz/ekonomicke-subjekty-v-be/rest/ekonomicke-subjekty/01569651

Skúste prosím kód vyšperkovať úplne najlepšie, ako dokážete (PHP 7.4+, ošetrenie vstupov, error handling, dokumentácia, formátovanie kódu...).
