<?php

namespace App\Contacts;

use App\Commande;
use Mail;

use Illuminate\Support\Arr;

class Mails
{
    public static function nouvellesCommandes(array $commandes)
    {
        $commande = Arr::first($commandes, function ($value, $key) {
            return true;
        });
        $tab = ['commandes' => $commandes];
        session()->put(['commande' => Arr::first($commandes, function ($value, $key) {
            return true;
        })]);
        Mail::send('mails/mailNouvelleCommande', $tab, function($message) 
		{
            $commande = session()->get('commande');
			$message->to($commande->getFlux()->contact)->subject('Valor\'Emm : Nouvelle commande groupée d\'enlèvement');
        });
    }


    public static function nouvelleCommande(Commande $commande)
    {
        $tab = ['commandes' => ['1' => $commande]];
        session()->put(['commande' => $commande]);
        Mail::send('mails/mailNouvelleCommande', $tab, function($message) 
		{
            $commande = session()->get('commande');
			$message->to($commande->getFlux()->contact)->subject('Valor\'Emm : Nouvelle commande d\'enlèvement numéro ' . strval($commande->numero));
        });
    }

    public static function modifCommande(Commande $commande)
    {
        $tab = ['commande' => $commande];
        session()->put(['commande' => $commande]);
        Mail::send('mails/mailModifCommande', $tab, function($message) 
		{
            $commande = session()->get('commande');
			$message->to($commande->getFlux()->contact)->subject('Valor\'Emm : Modification de la commande numéro '.strval($commande->numero));
        });
    }

    public static function delCommande(Commande $commande)
    {
        $tab = ['commande' => $commande];
        session()->put(['commande' => $commande]);
        Mail::send('mails/mailSuppressionCommande', $tab, function($message) 
		{
            $commande = session()->get('commande');
			$message->to($commande->getFlux()->contact)->subject('Valor\'Emm : Annulation de la commande numéro '.strval($commande->numero));
        });
    }

    public static function rappelCommande(Commande $commande)
    {
        $tab = ['commande' => $commande];
        session()->put(['commande' => $commande]);
        Mail::send('mails/mailRelanceCommande', $tab, function($message) 
		{
            $commande = session()->get('commande');
			$message->to($commande->getFlux()->contact)->subject('Valor\'Emm : Relance pour la commande numéro '.strval($commande->numero));
        });
    }

}