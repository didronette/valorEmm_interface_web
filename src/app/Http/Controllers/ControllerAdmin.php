<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\User;
use App\Commande;


use Illuminate\Support\Facades\DB;

class ControllerAdmin extends Controller
{
    public function accueil() // Fonction pour l'affichage de l'accueil
	{
		return view('admin/VueAdmin');
    }

    public static function mailModifCompte($user,$password) // Fonction pour l'affichage de l'accueil
	{
        $tab = ['user' => $user, 'password' => $password];
        session()->put(['user' => $user]);
        Mail::send('mails/mailModifCompte', $tab, function($message) 
		{
            $user = session()->get('user');
			$message->to($user->email)->subject('Modification de votre compte sur l\'interface déchetterie de Valor\'Emm');
    });
    }

    public static function mailNouveauCompte($user,$password) // Fonction pour l'affichage de l'accueil
	{
        $tab = ['user' => $user, 'password' => $password];
        session()->put(['user' => $user]);
        Mail::send('mails/mailNouveauCompte', $tab, function($message) 
		{
            $user = session()->get('user');
			$message->to($user->email)->subject('Création de votre compte sur l\'interface déchetterie de Valor\'Emm');
    });
    }

    
    public function chartjs()
    {
 
        $class="voice";
        $method="sendvoice";
        $user="thierry.stauder@valoremm.fr";
        $password="UnYLfQLG7mxkXm4A";
        $to="33651292806";
        $from="0";
        //$message="Le+problème+c'est+les+espaces.+Nicole+ça+va+pas+3.";
        $scheduledatetime="";
        $language="fr";
        $output="";

        //$result = file_get_contents("https://www.afilnet.com/api/http/?class=".$class."&method=".$method."&user=".$user."&password=".$password."&to=".$to."&from=".$from."&message=".$message."&scheduledatetime=".$scheduledatetime."&language=".$language."&output=".$output);
          
        $class="sms";
        $method="sendsms";
        $sms="Wallah+cette+api+y+a+rien+qui+va";

        //$result = file_get_contents("https://www.afilnet.com/api/http/?class=".$class."&method=".$method."&user=".$user."&password=".$password."&from=".$from."&to=".$to."&sms=".$sms."&scheduledatetime=".$scheduledatetime."&output=".$output);


        $chartjs = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(['Label x', 'Label y'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB'],
                'data' => [69, 59]
            ]
        ])
        ->options([]);

        return view('test', compact('chartjs'));
    }
   
}
