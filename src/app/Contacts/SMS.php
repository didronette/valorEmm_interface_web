<?php

namespace App\Contacts;

use App\Commande;
use App\Contacts\BuzzExpert;
use Illuminate\Support\Arr;


class SMS
{
    public static function nouvellesCommandes(array $commandes)
    {
        $commande = Arr::first($commandes, function ($value, $key) {
            return true;
        });
        $contenu = 'Bonjour madame, monsieur, voici les nouvelles commandes du jour : ';
        foreach ($commandes as $commande) {
            $contenu = $contenu.'Commande numéro '.$commande->numero.' : '.$commande->getFlux()->type.' (x'.$commande->multiplicite.')      ';
        }
        $contenu = $contenu.' pour la déchetterie de '.$commande->getDechetterie()->nom.', merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,true);
    }


    public static function nouvelleCommande(Commande $commande)
    {
        $contenu = 'Bonjour madame, monsieur, voici la nouvelle commande numéro '.$commande->numero.' : '.$commande->getFlux()->type.' (x'.$commande->multiplicite.')';
        $contenu = $contenu.' pour la déchetterie de '.$commande->getDechetterie()->nom.', merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,false);
    }

    public static function modifCommande(Commande $commande)
    {
        $contenu = 'ERRATUM : Bonjour madame, monsieur, la commande numéro '.$commande->numero.' est modifiée : '.$commande->getFlux()->type.' (x'.$commande->multiplicite.')';
        $contenu = $contenu.' pour la déchetterie de '.$commande->getDechetterie()->nom.', merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,false);
    }

    public static function delCommande(Commande $commande)
    {
        $contenu = 'ERRATUM : Bonjour madame, monsieur, la commande numéro '.$commande->numero.' est suprimée, merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,false);
    }

    public static function rappelCommande(Commande $commande)
    {
        $contenu = 'Rappel : Bonjour madame, monsieur, la commande numéro ' . strval($commande->numero) . ' n\'a pas été enlevée :'.$commande->getFlux()->type.' (x'.$commande->multiplicite.')';
        $contenu = $contenu.' pour la déchetterie de '.$commande->getDechetterie()->nom.', merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,false);
    } 

    public static function envoyerSMS($contenu, $numero,$auto) {
        $login    = \Config::get('tel.buzzexpert_login');
        $password = \Config::get('tel.buzzexpert_pasword');

        $Buzz = new BuzzExpert($login, $password);
        
        $contenu_arr = array(
            $contenu,
        );

        $options = array(
            //'oadc'  => 'TELEMAQUE',
            'label' => 'VALOR\'EMM',
            'type'  => 'ALERTING',
        );

        print_r(strlen($contenu));
        print_r($contenu);
        if (!$response = $Buzz->push($numero, 'SMS', $contenu_arr, $options)) {
            self::ecrireLog(print_r($Buzz->getLastError()),$auto);
        }
        ob_start();
        var_dump($response);
        self::ecrireLog(ob_get_clean(),$auto);
    }

    public static function ecrireLog($log,$auto) {        
        if ($auto) {
            $fp = fopen('./storage/log_SMS.txt', 'a');//opens file in append mode
        }
        else {
            $fp = fopen('../storage/log_SMS.txt', 'a');//opens file in append mode
        }
        fwrite($fp, $log);   
        fclose($fp); 
    }

}