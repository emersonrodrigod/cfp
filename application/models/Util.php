<?php

class Util {

    public static function mesExtenso($mes) {

        switch ($mes) {
            case 1: return "Janeiro";
            case 2: return "Fevereiro";
            case 3: return "Março";
            case 4: return "Abril";
            case 5: return "Maio";
            case 6: return "Junho";
            case 7: return "Julho";
            case 8: return "Agosto";
            case 9: return "Setembro";
            case 10: return "Outubro";
            case 11: return "Novembro";
            case 12: return "Dezembro";
        }
    }

    public static function dataMysql($data) {
        $dt = trim($data);

        if (strstr($dt, "/")) {

            $aux2 = explode("/", $dt);

            $datai2 = $aux2[2] . "-" . $aux2[1] . "-" . $aux2[0];

            return $datai2;
        }
    }

    public static function dataToText($data) {
        $dt = trim($data);

        if (strstr($dt, "-")) {

            $aux2 = explode("-", $dt);

            $datai2 = $aux2[2] . "/" . $aux2[1] . "/" . $aux2[0];

            return $datai2;
        }
    }

    public static function currencyToMysql($currency) {

        $toReturn = str_replace('.', '', $currency);
        $toReturn = str_replace(',', '.', $toReturn);
        $toReturn = str_replace('R$', '', $toReturn);
        $toReturn = trim($toReturn);
        return $toReturn;
    }

}
