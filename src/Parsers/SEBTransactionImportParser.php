<?php

namespace Parsers;

use Entities\Payment;

/**
 * Parser for SEB transaction import file format documents
 * From the docs (http://www.seb.ee/files/juhendid/Importfailide_kirjeldus.pdf):
 *
 * Rida    Kirje sisu                                  Formaat         Väärtus
 * 1       kirje tunnus                                Tekst           #7
 * 2       väljade arv kirjes                          Täisarv         14
 * 3       tehingu/operatsiooni id                     Tekst
 * 4       tehingu teostamise aeg                      ddmmyyyy
 * 5       Dokumendi number                            tekst [...8]
 * 6       Viitenumber                                 Tekst
 * 7       tehingu summa vähimais ühikuis              ±täisarv
 * 8       tehingu vastaspoole nimi                    Tekst
 * 9       tehingu vastaspoole arvelduskonto number    tekst [3...16]
 * 10      Tehinguinfo/selgitus                        tekst [...255]
 * 11      Tühi kirje
 * 12      Tühi kirje
 * 13      tehingu vastaspoole panga kood Tekst
 * 14      tehingu vastaspoole id.-kood (isikukood /
 * ettev. reg. nr.)                            Tekst
 * 15      Maksepäev                                   ddmmyyyy
 * 16      Tühi kirje
 *
 * @package Parsers
 */
class SEBTransactionImportParser extends AbstractParser implements Parser
{
    /**
     * SEBTransactionImportParser constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Parse stream and return array object of parsed payments
     *
     * @param string $stream Stream of data to parse to payments
     * @return \ArrayObject
     * @throws \Exception when format is unrecognized
     */
    public function parseData($stream)
    {
        $amountPadding = 6;
        $paymentNoPadding = 2;
        $descriptionPadding = 9;
        $payerNamePadding = 7;
        $referenceNoPadding = 0;

        $result = new \ArrayObject();
        $rows = explode("\n", $stream);
        $trimmedRows = $rows;
        for ($i = 0; $i < count($trimmedRows); $i++) {
            if ($trimmedRows[$i] == '#7') {
                $amount = (int)substr($trimmedRows[$i + $amountPadding], 0, 11) . ',' . substr($trimmedRows[$i + $amountPadding], 11, 2);
                $paymentNo = trim($trimmedRows[$i + $paymentNoPadding]);
                $description = trim($trimmedRows[$i + $descriptionPadding]);
                $payerName = trim($trimmedRows[$i + $payerNamePadding]);
                $referenceNo = "";//TODO: in what location is reference no?
                $payment = new Payment($amount, $paymentNo, $description, $payerName, $referenceNo);
                $result->append($payment);
                //skip the entry
                $i = $i + $trimmedRows[$i + 1];
            }
        }
        return $result;
    }
}