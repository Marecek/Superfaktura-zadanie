DROP TABLE IF EXISTS `duplicates`;

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

--Riešenie:
SELECT DISTINCT d.*
FROM duplicates d
         JOIN duplicates dup ON d.value = dup.value
WHERE d.id != dup.id
ORDER BY d.id;
