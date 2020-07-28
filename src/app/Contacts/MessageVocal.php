<?php

namespace App\Contacts;

use App\Commande;

//use App\Support\ProcessBuilder;
use Symfony\Component\Process\Process;
use Illuminate\Support\Arr;



class MessageVocal
{

    public static function nouvellesCommandes(array $commandes)
    {
        $commande = Arr::first($commandes, function ($value, $key) {
            return true;
        });
        $contenu = 'Bonjour madame, monsieur, voici les nouvelles commandes du jour : ';
        foreach ($commandes as $commande) {
            $contenu = $contenu . self::formulation($commande);
        }

        $contenu = $contenu .' pour la déchetterie de '.$commande->getDechetterie()->nom;
        $contenu = $contenu .' Cordialement Valor\'Emm'; 
        self::creerMessageVocal($contenu,true);
        $numero = $commande->getFlux()->contact;
        self::envoyerVocal($numero,true);
    }

    public static function nouvelleCommande(Commande $commande)
    {
        $contenu = 'Bonjour madame, monsieur, voici la nouvelle'.self::formulation($commande).' pour la déchetterie de '.$commande->getDechetterie()->nom.' . '.' Cordialement Valor\'Emm.';
        self::creerMessageVocal($contenu,false);
        $numero = $commande->getFlux()->contact;
        self::envoyerVocal($numero,false);
    }

    public static function modifCommande(Commande $commande)
    {
        $contenu = 'Modification de commande : Bonjour madame, monsieur, commande modifiée '.self::formulation($commande).' pour la déchetterie de '.$commande->getDechetterie()->nom.'. '.'Cordialement Valor\'Emm.';
        self::creerMessageVocal($contenu,false);
        $numero = $commande->getFlux()->contact;
        self::envoyerVocal($numero,false);
    }

    public static function delCommande(Commande $commande)
    {
        $contenu = 'Supression de commande : Bonjour madame, monsieur, la commande numéro '.$commande->numero.' est suprimée.'.' Cordialement Valor\'Emm.';
        self::creerMessageVocal($contenu,false);
        $numero = $commande->getFlux()->contact;
        self::envoyerVocal($numero,false);
    }

    public static function rappelCommande(Commande $commande)
    {
        $contenu = 'Rappel : Bonjour madame, monsieur, une commande n\'a pas été enlevée : '.self::formulation($commande).' Cordialement Valor\'Emm.';
        self::creerMessageVocal($contenu,false);
        $numero = $commande->getFlux()->contact;
        self::envoyerVocal($numero,false);
    }

    public static function envoyerVocal($numero,$auto) {
        $login    = \Config::get('tel.buzzexpert_login');
        $password = \Config::get('tel.buzzexpert_pasword');

        $Buzz = new BuzzExpert($login, $password);
        

        $options = array(
            'caller_num' => \Config::get('tel.numero_appellant')
        );

        if (!$auto) {
            if (!$response = $Buzz->push($numero, 'VOICE', array('../storage/appel.wav'), $options)) {
                self::ecrireLog($Buzz->getLastError());
            }
        }
        else {
            if (!$response = $Buzz->push($numero, 'VOICE', array('./storage/appel.wav'), $options)) {
                self::ecrireLog($Buzz->getLastError(),$auto);
            }            
        }
        

        ob_start();
        var_dump($Buzz);
        self::ecrireLog(ob_get_clean(),$auto);

        
    }

    public static function ecrireLog($log,$auto) {
        if ($auto) {
            $fp = fopen('./storage/log_Appel.txt', 'a');//opens file in append mode
        }
        else {
            $fp = fopen('../storage/log_Appel.txt', 'a');//opens file in append mode
        }
          
        fwrite($fp, $log);   
        fclose($fp); 
    }

    public static function creerMessageVocal($texte,$auto) 
    {
        if ($auto) {
            $command = 'pico2wave -l fr-FR -w ./storage/appel.wav ' .'"'.$texte.'"';
        }
        else {
            $command = 'pico2wave -l fr-FR -w ../storage/appel.wav ' .'"'.$texte.'"';
        }
        
        $process = new Process($command);
        $process->run();
    }

    public static function formulation($commande) {
        if ($commande->getFlux()->categorie == "Benne") {
            return ' commande numéro '.$commande->numero . ' : '. $commande->multiplicite . ' bennes de '.$commande->getFlux()->type.'. ';
        }
        else if ($commande->getFlux()->categorie == "DDS") {
            return ' commande numéro '.$commande->numero . ' : '. $commande->multiplicite . ' caisses de '.$commande->getFlux()->type.'. ';
        }
        else {
            return ' commande numéro '.$commande->numero . ' : enlèvement de '.$commande->getFlux()->type.'. ';
        }
    }
}