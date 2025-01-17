### Riešenie zadania 2:

```sh
SELECT DISTINCT d.*
FROM duplicates d
JOIN duplicates dup ON d.value = dup.value
WHERE d.id != dup.id
ORDER BY d.id;
```

### Argumentácia riešenia:

**Ano, riešenie bude fungovať aj s veľkým počtom riadkov**.

- Query používa DISTINC namiesto GROUP BY v rámci efektívnejšieho vylistovania duplikátnych záznamov nakoľko nie sú potrebné agretátne operácie s výsledkom
- Query používa INNER JOIN namiesto subquery (rýchlejšie)
- Pre filtráciu duplikátou je použitá podmienka WHERE (rýchlejšie ako pre filtrovanie cez HAVING pri GROUP BY), s jedndoduchou porovnávacou logikou (namiesto potreby využita napr. COUNT > 1)
- Zoradenie podľa je optional (nakoľko nebolo v zadaní) 

Query by nemalo mať problém ani s väčším počtom záznamov.

---------------------------

### Zadanie 2 * 2. databázová. *:

*Máte jednoduchú tabuľku s primárnym kľúčom a hodnotou v druhom stĺpci. Niektoré z týchto hodnôt môžu byť duplicitné. Napíšte prosím SQL query, ktorá vráti všetky riadky z tabuľky s duplicitnými hodnotami (*celé* riadky).*

*Definícia tabuľky a vzorové dáta:*

```sh
CREATE TABLE `duplicates` 
( 
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) 
ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
```
#### Želaný výstup:

```sh

+----+-------+
| id | value |
+----+-------+
|  2 |     2 |
|  4 |     2 |
|  5 |     4 |
|  6 |     4 |
|  8 |     6 |
|  9 |     6 |
| 10 |     2 |
+----+-------+
```

**Bude vaše riešenie efektívne fungovať aj na tabuľke s veľkým počtom riadkov (milión a viac)? Vysvetlite prečo a ako.**