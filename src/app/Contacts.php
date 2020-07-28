<?php

namespace App;

use App\Commande;

use App\Contacts\Mails;
use App\Contacts\MessageVocal;
use App\Contacts\SMS;

use App\Contacts\BuzzExpert;

use Illuminate\Support\Arr;

use Illuminate\Support\Facades\DB;

class Contacts
{
    public static function commandeAEnvoyer()
    {
        $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'En attente d\'envoie')
            ->whereRaw('abs(UNIX_TIMESTAMP(contact_at) - UNIX_TIMESTAMP(now())) <40') // On check la date de la commande à une minute près
            ->get();

        return (!($commandes->isEmpty()));
    } 

    public static function envoyerCommande()
    {
        $commandes = Commande::select(DB::raw('t.*'))
            ->from(DB::raw('(SELECT c.* FROM Commande c INNER JOIN ( SELECT numero, MAX(id) AS maxDate FROM Commande GROUP BY numero ) groupeC ON c.numero = groupeC.numero AND c.id = groupeC.maxDate) t'))
            ->where('statut', '=', 'En attente d\'envoie')
            ->whereRaw('abs(UNIX_TIMESTAMP(contact_at) - UNIX_TIMESTAMP(now())) < 40') // On check la date de la commande à une minute près
            ->get();
            
        $commandes_groupees = [];
        foreach ($commandes as $commande) {
            $contact = $commande->getFlux()->contact;
            $dechetterie =  $commande->dechetterie;
            $commandes_groupees[$contact.$dechetterie][$commande->numero] = $commande;
        }

        foreach ($commandes_groupees as $groupe_commande) {
            self::nouvellesCommande($groupe_commande);
        }

    }
    
    public static function commandeContact()
    {

        if (self::commandeAEnvoyer()) {
            self::envoyerCommande();
        }
    }

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

    public static function creditRestant() {
        $login    = \Config::get('tel.buzzexpert_login');
        $password = \Config::get('tel.buzzexpert_pasword');

        $Buzz = new BuzzExpert($login, $password);

        return $Buzz->remainCredit();
    }

}