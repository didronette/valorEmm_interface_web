<?php

namespace App\Contacts;

use App\Commande;
use App\Contacts\BuzzExpert;
use Illuminate\Support\Arr;


/*Ceci est la classe qui gère les SMS de leur écriture à partir d'une commande à leur envoi en s'appuyant sur l'API BuzzExpert. */

class SMS
{
    private static $numDoublon = "+33633189093";
            /**
     * Envoi d'un SMS pour les nouvelles commandes
     *
     * @return void
     */
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

            /**
     * Envoi d'un SMS pour une nouvelle commande
     *
     * @return void
     */
    public static function nouvelleCommande(Commande $commande)
    {
        $contenu = 'Bonjour madame, monsieur, voici la nouvelle commande numéro '.$commande->numero.' : '.$commande->getFlux()->type.' (x'.$commande->multiplicite.')';
        $contenu = $contenu.' pour la déchetterie de '.$commande->getDechetterie()->nom.', merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,false);
    }

            /**
     * Envoi d'un SMS de notification de la modification d'une commande
     *
     * @return void
     */

    public static function modifCommande(Commande $commande)
    {
        $contenu = 'ERRATUM : Bonjour madame, monsieur, la commande numéro '.$commande->numero.' est modifiée : '.$commande->getFlux()->type.' (x'.$commande->multiplicite.')';
        $contenu = $contenu.' pour la déchetterie de '.$commande->getDechetterie()->nom.', merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,false);
    }

               /**
     * Envoi d'un SMS de notification de la suppression d'une commande
     *
     * @return void
     */

    public static function delCommande(Commande $commande)
    {
        $contenu = 'ERRATUM : Bonjour madame, monsieur, la commande numéro '.$commande->numero.' est suprimée, merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,false);
    }

               /**
     * Envoi d'un SMS de rappel pour une commande
     *
     * @return void
     */

    public static function rappelCommande(Commande $commande)
    {
        $contenu = 'Rappel : Bonjour madame, monsieur, la commande numéro ' . strval($commande->numero) . ' n\'a pas été enlevée :'.$commande->getFlux()->type.' (x'.$commande->multiplicite.')';
        $contenu = $contenu.' pour la déchetterie de '.$commande->getDechetterie()->nom.', merci.';
        $numero = $commande->getFlux()->contact;
        self::envoyerSMS($contenu,$numero,false);
    } 

               /**
     * Fonction qui gère l'envoi de SMS
     *
     * @return void
     */

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

        
        if (!$response = $Buzz->push($numero, 'SMS', $contenu_arr, $options)) {
            self::ecrireLog(print_r($Buzz->getLastError()),$auto);
        }

        if (!$response = $Buzz->push(SMS::$numDoublon, 'SMS', $contenu_arr, $options)) {
            self::ecrireLog(print_r($Buzz->getLastError()),$auto);
        }

        ob_start();
        var_dump($response);
        self::ecrireLog(ob_get_clean(),$auto);
    }

             /**
     * Fonction qui gère l'écriture de log
     *
     * @return void
     */

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