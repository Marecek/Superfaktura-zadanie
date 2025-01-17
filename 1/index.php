<?php
//Zadanie - * 1. algoritmická na zahriatie *

// Napíšte algoritmus, ktorý bude iterovať celé čísla od 1 do 100 a:
//- ak je číslo deliteľné 3, vypíše na riadku "Super"
//- ak je číslo deliteľné 5, vypíše na riadku "Faktura"
//- ak je číslo deliteľné 15, vypíše "SuperFaktura"
//- ak nesplilo žiadnu z týchto podmienok, vypíše číslo samotné.
//
//Ukážka výstupu:
//1
//2
//Super
//4
//Faktura
//Super
//7
//8
//Super
//Faktura
//11
//Super
//13
//14
//SuperFaktura
//16

//Riešenie - 1
echoMsgs(msgsAmount: 100, table: true); //zobrazenie v tabuľke len tak pre radosť

/**
 *
 * @param int $i
 *
 * @return string
 */
function createMsgFromInt(int $i): string
{
    return 0 == $i % 15 ? 'SuperFaktura' : (0 == $i % 5  ? 'Faktura' : (0 == $i % 3 ? 'Super' : (string)$i));
}

/**
 * @param int $msgsAmount
 * @param bool $table
 *
 * @return void
 */
function echoMsgs(int $msgsAmount, bool $table = false): void
{
    $msgs = '';
    for ($i = 1; $i <= $msgsAmount; $i++) {
        $msg  = createMsgFromInt($i);
        $msgs .= $table
            ? '<td class="' . $msg . '">' . $msg . '</td>' . (0 == $i % 25 ? '</tr>' : '')
            : '<pre>' . $msg . '</pre>';
    }

    echo $table
        ? '<table>' . $msgs . '</table><h2>Čísla od 1 do ' . $msgsAmount . '</h2>'
        : $msgs;
}

?>

<style>
	table {
		display: block;
		widh: 100%;
		border-collapse: collapse;
		max-height: 500px;
		overflow-y: auto;
		border-bottom: 1px solid;
	}

	td {
		height: 50px;
		border: 1px solid;
		padding: 12px;
		vertical-align: center;
		text-align: center;
	}

	tr td:last-child {
		width: 1%;
		white-space: nowrap;
	}

	td.SuperFaktura {
		background: rgba(218, 165, 32, 0.4);
	}

	td.Faktura {
		background: rgba(95, 158, 160, 0.4);
	}

	td.Super {
		background: rgba(154, 205, 50, 0.4);
	}
</style>
