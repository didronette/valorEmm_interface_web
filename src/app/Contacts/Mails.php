<?php

namespace App\Contacts;

use App\Commande;
use Mail;

use Illuminate\Support\Arr;

/*Ceci est la classe qui gère les mails de leur écriture à partir d'une commande à leur envoi via la façade Mail et le protocole SMTP. */


class Mails
{

    /**
     * Envoi de mail pour les nouvelles commandes
     *
     * @return void
     */
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
    /**
     * Envoi d'un mail pour une nouvelle commande
     *
     * @return void
     */

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

    /**
     * Envoi de mail de notification de la modification d'une commande
     *
     * @return void
     */

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

    /**
     * Envoi de mail de notification de la suppression d'une commande
     *
     * @return void
     */

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

    /**
     * Envoi de mail de rappel pour une commande
     *
     * @return void
     */

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
