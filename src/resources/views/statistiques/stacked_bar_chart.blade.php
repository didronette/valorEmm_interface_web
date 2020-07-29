<?php 
function generer_tab_couleur($couleur,$tab_donnees) {
    $retour = [];
    foreach ($tab_donnees as $key => $value) {
        $retour[$key] = $couleur;
    }
    return $retour;
}

$couleur_pas_enlevee = 'rgba(0, 0, 0, 1)';
$couleur_nc = 'rgba(32, 40, 244, 1)'; 
$couleur_nc_agglo = 'rgba(194, 9, 219, 1)';
$couleur_retard_enlevement = 'rgba(244, 40, 12, 1)';
$couleur_ok = 'rgba(96, 244, 12, 1)';

$datasets = [];

if ($enlevement) {
    array_push($datasets,[
        "label" => "Retard sur enlèvement",
        'backgroundColor' => generer_tab_couleur($couleur_retard_enlevement,$donnees_retard_enlevement),
        'data' => $donnees_retard_enlevement
    ]);

    array_push($datasets,[
        "label" => "Commandes en attente",
        'backgroundColor' => generer_tab_couleur($couleur_pas_enlevee,$donnees_pas_enlevee),
        'data' => $donnees_pas_enlevee
    ]);
}

if ($nc) {
    array_push($datasets,[
        "label" => "Non-conformité agent",
        'backgroundColor' => generer_tab_couleur($couleur_nc,$donnees_nc),
        'data' => $donnees_nc
    ]);
}

if ($ncagglo) {
    array_push($datasets,[
        "label" => "Non-conformité agglomération",
        'backgroundColor' => generer_tab_couleur($couleur_nc_agglo,$donnees_nc_agglo),
        'data' => $donnees_nc_agglo
    ]);
}

array_push($datasets,[
    "label" => "Commande OK",
    'backgroundColor' => generer_tab_couleur($couleur_ok,$donnees_ok),
    'data' => $donnees_ok
]);

$chartjs = app()->chartjs
->name('StatistiquesCommande')
->type('bar')
->size(['width' => 400, 'height' => 200])
->labels($dates)
->datasets($datasets)
->options([ 'title' => [
            'display' => true,
            'text' => 'Statistiques des commandes',
            'fontSize' => 40,
   
        ],
        'scales' => [
            'xAxes' => [[
                'stacked' => true,
            ]],
            'yAxes' => [[
                'stacked'=> true,
            ]]
        ]
]);
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>
    {!! $chartjs->render() !!}
