<?php

namespace App;

use Carbon;

class HelperDate
{

    
    private static $jour_feries = ['01-01','01-05','08-05','14-07','15-08','01-11','25-12','26-12'];

    public static function getDateOuvre(Carbon $date) {
        while(!(self::estOuvre($date))) {
            $date->addDay();
        }
        return $date;
    }
 

    public static function estOuvre(Carbon $date) {
        if ($date->dayOfWeek == 0) {
            return false;
        }
        else {
            foreach (self::getJourFeriesDependantsDePAques($date) as $jour_ferie) {
                if ($date->isSameDay($jour_ferie)) {
                    return false;
                }
            }

            foreach (self::getJourFeries($date) as $jour_ferie) {
                if ($date->isSameDay($jour_ferie)) {
                    return false;
                }
            }
        }

        return true;

    }

    

    public static function getJourFeriesDependantsDePAques($day) {
        $retour = [];
        $paques = self::getPaques($day);
        array_push( $retour, $paques); // paques
        array_push( $retour, $paques>copy()->subDays(2)); // vendredi saint : paques -2
        array_push( $retour, $paques>copy()->addDay()); // Lundi de pâques : dimanche de pâques + 1
        array_push( $retour, $paques>copy()->addDays(39)); // Ascension, élévation de Jésus : dimanche de pâques + 39
        array_push( $retour, $paques>copy()->addDays(50)); // Pentecôte, venue du Saint Esprit : dimanche de pâques + 50
  
        return $retour;
    }

    public static function getJourFeries($day) {
        $retour = [];
        foreach (self::$jour_feries  as $day_jm) {
            $day_jma = $day_jm.'-'.$day->year;
            
            array_push( $retour, Carbon::createFromFormat('d-m-Y', $day_jma) ); 

        }
        return retour;
    }

    public static function getPaques($day) {
        return Carbon(easter_date($day->year));
    }




 
}
