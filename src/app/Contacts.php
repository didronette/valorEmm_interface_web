<?php

namespace App;

use App\Commande;

use Mail;

use App\Contacts\Mails;
use App\Contacts\MessageVocal;
use App\Contacts\SMS;

use App\Contacts\BuzzExpert;

use Illuminate\Support\Arr;

use Illuminate\Support\Facades\DB;

class Contacts
{
    /**
     * Retourne vrai s'il existe une commande à envoyer
     */

    public static function commandeAEnvoyer()
    {
        $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'En attente d\'envoie')
            ->whereRaw('abs(UNIX_TIMESTAMP(contact_at) - UNIX_TIMESTAMP(now())) <40') // On check la date de la commande à une minute près
            ->get();

        return (!($commandes->isEmpty()));
    }
    
    /**
     * Réalise l'envoi des commandes à envoyer
     */

    public static function envoyerCommande()
    {
        $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'En attente d\'envoie')
            ->whereRaw('abs(UNIX_TIMESTAMP(contact_at) - UNIX_TIMESTAMP(now())) < 40') // On check la date de la commande à une minute près
            ->get();
            
        $commandes_groupees = [];
        foreach ($commandes as $commande) {
            $societe = $commande->getFlux()->societe;
            $contact = $commande->getFlux()->contact;
            $dechetterie =  $commande->dechetterie;
            $commandes_groupees[$societe.$contact.$dechetterie][$commande->numero] = $commande;
        }

        foreach ($commandes_groupees as $groupe_commande) {
            self::nouvellesCommande($groupe_commande);
        }

    }

    /**
     * Réalise l'envoi des commandes à envoyer si il y en a (fonction appelée automatiquement toutes les minutes)
     */
    
    public static function commandeContact()
    {

        if (self::commandeAEnvoyer()) {
            self::envoyerCommande();
        }
    }

/**
     * Réalise l'envoi de plusieurs nouvelles commandes
     */

    public static function nouvellesCommande(array $commandes)
    {
        $commande = Arr::first($commandes, function ($value, $key) {
            return true;
        });
        if ($commande->getFlux()->type_contact == 'MAIL') {
            Mails::nouvellesCommandes($commandes);
        } else if ($commande->getFlux()->type_contact == 'APPEL') {
            MessageVocal::nouvellesCommandes($commandes);
        } else if ($commande->getFlux()->type_contact == 'SMS') {
            SMS::nouvellesCommandes($commandes);
        }

        foreach ($commandes as $commande) {
            $enregistrement = $commande->replicate();
            $enregistrement->statut='Passée';
            $enregistrement->compte=\App\Repositories\UserRepository::getSysteme()->id;
            $enregistrement->save();
        }

        
    }

    /**
     * Réalise l'envoi d'une nouvelle commande
     */


    public static function nouvelleCommande(Commande $commande)
    {
        if ($commande->getFlux()->type_contact == 'MAIL') {
            Mails::nouvelleCommande($commande);
        } else if ($commande->getFlux()->type_contact == 'APPEL') {
            MessageVocal::nouvelleCommande($commande);
        } else if ($commande->getFlux()->type_contact == 'SMS') {
            SMS::nouvelleCommande($commande);
        }

        $enregistrement = $commande->replicate();
        $enregistrement->statut='Passée';
        $enregistrement->compte=\App\Repositories\UserRepository::getSysteme()->id;
        $enregistrement->save();
    }

    /**
     * Réalise l'envoi d'une modification de commande
     */

    public static function modifCommande(Commande $commande)
    {
        if ($commande->getFlux()->type_contact == 'MAIL') {
            Mails::modifCommande($commande);
        } else if ($commande->getFlux()->type_contact == 'APPEL') {
            MessageVocal::modifCommande($commande);
        } else if ($commande->getFlux()->type_contact == 'SMS') {
            SMS::modifCommande($commande);
        }
    }

    /**
     * Réalise la notification de la suppression d'une commande
     */

    public static function delCommande(Commande $commande)
    {
        if ($commande->getFlux()->type_contact == 'MAIL') {
            Mails::delCommande($commande);
        } else if ($commande->getFlux()->type_contact == 'APPEL') {
            MessageVocal::delCommande($commande);
        } else if ($commande->getFlux()->type_contact == 'SMS') {
            SMS::delCommande($commande);
        }
    }

        /**
     * Réalise la notification du rappel d'une commande
     */

    public static function rappelCommande(Commande $commande)
    {
        if ($commande->getFlux()->type_contact == 'MAIL') {
            Mails::rappelCommande($commande);
        } else if ($commande->getFlux()->type_contact == 'APPEL') {
            MessageVocal::rappelCommande($commande);
        } else if ($commande->getFlux()->type_contact == 'SMS') {
            SMS::rappelCommande($commande);
        }
    }

       /**
     * Renvoie le nombre de crédit Buzz Expert restants
     */

    public static function creditRestant() {
        $login    = \Config::get('tel.buzzexpert_login');
        $password = \Config::get('tel.buzzexpert_pasword');

        $Buzz = new BuzzExpert($login, $password);

        return intval($Buzz->remainCredit());
    }

    public static function mailCreditsRestants() {
        $credits = self::creditRestant();
        if ($credits < 100) {
            $tab = ['credits' => $credits];
            Mail::send('mails/mailCreditsManquants', $tab, function($message) 
            {
    
                $message->to("thierry.stauder@valoremm.fr")->subject('Interface Déchetterie Valor\'Emm : Nombre de crédits restants faible');
            });
        
        }
    }

    public static function mailIncident(Incident $incident) {
        
        $tab = ['incident' => $incident];
        Mail::send('mails/mailIncident', $tab, function($message) 
        {
            $message->to("cafpf@valoremm.fr")->subject('Interface Déchetterie Valor\'Emm : Un nouvel incident vient d\'être créé');
        });
        
    
    }   

}