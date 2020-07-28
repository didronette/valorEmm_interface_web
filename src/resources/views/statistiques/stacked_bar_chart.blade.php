<?php 
function generer_tab_couleur($couleur,$tab_donnees) {
    $retour = [];
    foreach ($tab_donnees as $key => $value) {
        $retour[$key] = $couleur;
    }
    return $retour;
}

$couleur_nc = 'rgba(32, 40, 244, 1)'; 
$couleur_nc_agglo = 'rgba(194, 9, 219, 1)';
$couleur_retard_enlevement = 'rgba(244, 40, 12, 1)';
$couleur_ok = 'rgba(96, 244, 12, 1)';

$chartjs = app()->chartjs
->name('StatistiquesCommande')
->type('bar')
->size(['width' => 400, 'height' => 200])
->labels($dates)
->datasets([
    [
        "label" => "Non-conformité agent",
        'backgroundColor' => generer_tab_couleur($couleur_nc,$donnees_nc),
        'data' => $donnees_nc
    ],
    [
        "label" => "Non-conformité agglomération",
        'backgroundColor' => generer_tab_couleur($couleur_nc_agglo,$donnees_nc_agglo),
        'data' => $donnees_nc_agglo
    ],
    [
        "label" => "Retard sur enlèvement",
        'backgroundColor' => generer_tab_couleur($couleur_retard_enlevement,$donnees_retard_enlevement),
        'data' => $donnees_retard_enlevement
    ],
    [
        "label" => "Commande OK",
        'backgroundColor' => generer_tab_couleur($couleur_ok,$donnees_ok),
        'data' => $donnees_ok
    ]
])
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
