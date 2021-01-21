<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Ce fichier contient la définition des routes web de l'application. Ces
| routes sont chargées par le RouteServiceProvider dans un groupe
| contenant le groupe de web de middleware.
|
*/

Route::get('/', function() {return redirect()->route('login');}); // Redirection sur le login si quelqu'un tente d'accéder à la racine


// ############################# Routes pour l'authentification #############################

Auth::routes();
Route::get('login/{token}', 'ControllerCommande@auth_dechet'); // Page d'identification d'une déchetterie


// ############################# Routes pour l'administrateur #############################

Route::get('admin', 'ControllerAdmin@accueil')->middleware('gestion')->name('admin'); // Page d'accueil pour l'administrateur
Route::resource('admin/dechetteries', 'ControllerDechetterie')->middleware('gestion'); // Page de gestion des déchetteries
Route::resource('admin/flux', 'ControllerFlux')->middleware('gestion'); // Page de gestion des flux
Route::resource('admin/comptes', 'ControllerUser')->middleware('gestion'); // Page de gestion des comptes

// ############################# Routes pour les commandes #############################

Route::resource('saisie/commandes', 'ControllerCommande')->middleware('commandes'); // Page de gestion des commandes (individuelles)
Route::get('saisie/gr/commandes', 'ControllerCommande@indexGroupe')->middleware('commandes')->name('indexGr'); // Page de gestion des commandes (groupée)
Route::get('saisie/gr/rappel/{id}', 'ControllerCommande@rappelGroupe')->middleware('commandes')->name('rappelGr')->where('id', '[0-9]+'); // Page de confirmation de l'envoi d'un rappel (groupé)
Route::post('saisie/gr/commandes/rappel/confirmation', 'ControllerCommande@confirmRappelGroupe')->middleware('commandes')->name('confirmerRappelGr'); // Envoi du rappel (groupé)
Route::get('saisie/gr/view/{id}', 'ControllerCommande@showGroupe')->middleware('commandes')->name('vueGr')->where('id', '[0-9]+'); // Visionnage de commande (groupée) 
Route::get('saisie/gr/validation/{id}', 'ControllerCommande@formulaireValidationGroupe')->middleware('commandes')->name('formulaireValidationGr')->where('id', '[0-9]+'); // Formulaire de validation de d'un groupe de commande
Route::post('saisie/gr/validation', 'ControllerCommande@validationGroupe')->middleware('commandes')->name('validationGr'); // Validation d'un groupe de commande
Route::post('saisie/gr/commandes/validation/confirmation', 'ControllerCommande@confirmValidationGroupe')->middleware('commandes')->name('confirmerValidationGr'); // Confirmation de la validation groupée


Route::get('saisie/commandes/create/benne', 'ControllerCommande@createBenne')->middleware('commandes')->name('benne'); // Création d'une nouvelle commande de benne
Route::get('saisie/commandes/create/dds', 'ControllerCommande@createDDS')->middleware('commandes')->name('dds'); // Création d'une nouvelle commande de DDS
Route::get('saisie/commandes/create/autres', 'ControllerCommande@createAutre')->middleware('commandes')->name('autres'); // Création d'une nouvelle commande de catégorie "autres déchets"
Route::post('saisie/commandes/ajouter', 'ControllerCommande@stack')->middleware('commandes')->name('ajouterPlusieursCommandes'); // Ajout d'une nouvelle commande au groupe


Route::post('saisie/commandes/create/confirmation', 'ControllerCommande@confirmStore')->middleware('commandes')->name('confirmerNouvelleCommande'); // Confirmation d'une nouvelle commande
Route::post('saisie/commandes/update/confirmation', 'ControllerCommande@confirmUpdate')->middleware('commandes')->name('confirmerModifCommande'); // Modification d'une commande
Route::post('saisie/commandes/delete/confirmation', 'ControllerCommande@confirmDestroy')->middleware('commandes')->name('confirmerSuppression'); // Confirmation de la suppression d'une commande
Route::post('saisie/commandes/rappel/confirmation', 'ControllerCommande@confirmRappel')->middleware('commandes')->name('confirmerRappel'); // Confirmation du rappel d'une commande
Route::post('saisie/commandes/validation/confirmation', 'ControllerCommande@confirmValidation')->middleware('commandes')->name('confirmerValidation'); // Confirmation de la validation de l'enlèvement d'une commande

Route::get('saisie/listeContacts', 'ControllerCommande@listeContacts')->middleware('commandes')->name('listeContacts'); // Affichage de la liste des contacts
Route::get('saisie/validation/{id}', 'ControllerCommande@formulaireValidation')->middleware('commandes')->name('formulaireValidation')->where('id', '[0-9]+'); // Affichage du formulaire de validation d'une commande
Route::post('saisie/validation', 'ControllerCommande@validation')->middleware('commandes')->name('validation'); // Validation de l'enlèvement d'une commande
Route::get('saisie/rappel/{id}', 'ControllerCommande@rappel')->middleware('commandes')->name('rappel')->where('id', '[0-9]+'); // Affichage du formualire de confiramtion d'un rappel

// ############################# Routes pour l'interface de statistique #############################

Route::get('statistiques', 'ControllerStatistiques@vueStatistiques')->middleware('statistiques')->name('accueilAgglo'); // Affichage de l'interface statistique par défaut
Route::post('statistiques', 'ControllerStatistiques@updateVueStatistiques')->middleware('statistiques'); // Affichage de l'interface statistiques 

Route::get('statistiques/nc', 'ControllerStatistiques@vueNC')->middleware('statistiques')->name('ncAgglo'); // Affichage du formulaire de saisie de non-conformité agglo

Route::post('statistiques/nc', 'ControllerCommande@ajouterNcAgglo')->middleware('statistiques')->name('storeNcAgglo'); // Enregistrement d'une non-conformité agglo
Route::post('statistiques/rapport', 'ControllerStatistiques@genererRapport')->middleware('statistiques')->name('generateReport'); // Génération de rapport


// ############################# Routes pour les réponses et DLR BuzzExpert #############################


Route::post('be/dlr', 'ControllerBuzzExpert@storeDLR'); // Accusé reception
Route::post('be/rep', 'ControllerBuzzExpert@storeReponse'); // Réponses

Route::get('be/dlr', 'ControllerBuzzExpert@storeDLR'); // Route en théorie inutile mais nécéssaire au paramétrage
Route::get('be/rep', 'ControllerBuzzExpert@storeReponse'); // Route en théorie inutile mais nécéssaire au paramétrage

