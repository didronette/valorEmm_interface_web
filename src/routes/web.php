<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/* GESTION DES ROUTES */

// ############################# Routes pour l'authentification #############################

Auth::routes();


// ############################# Routes pour l'administrateur #############################

Route::get('admin', 'ControllerAdmin@accueil')->middleware('gestion')->name('admin'); // Page d'accueil pour l'administrateur
Route::resource('admin/dechetteries', 'ControllerDechetterie')->middleware('gestion');
Route::resource('admin/flux', 'ControllerFlux')->middleware('gestion');
Route::resource('admin/comptes', 'ControllerUser')->middleware('gestion');

// ############################# Routes pour les commandes #############################

Route::resource('saisie/commandes', 'ControllerCommande')->middleware('commandes');

Route::get('saisie/commandes/create/benne', 'ControllerCommande@createBenne')->middleware('commandes')->name('benne');
Route::get('saisie/commandes/create/dds', 'ControllerCommande@createDDS')->middleware('commandes')->name('dds');
Route::get('saisie/commandes/create/autres', 'ControllerCommande@createAutre')->middleware('commandes')->name('autres');

Route::post('saisie/commandes/create/confirmation', 'ControllerCommande@confirmStore')->middleware('commandes')->name('confirmerNouvelleCommande');
Route::post('saisie/commandes/update/confirmation', 'ControllerCommande@confirmUpdate')->middleware('commandes')->name('confirmerModifCommande');
Route::post('saisie/commandes/delete/confirmation', 'ControllerCommande@confirmDestroy')->middleware('commandes')->name('confirmerSuppression');
Route::post('saisie/commandes/rappel/confirmation', 'ControllerCommande@confirmRappel')->middleware('commandes')->name('confirmerRappel');
Route::post('saisie/commandes/validation/confirmation', 'ControllerCommande@confirmValidation')->middleware('commandes')->name('confirmerValidation');

Route::get('saisie/listeContacts', 'ControllerCommande@listeContacts')->middleware('commandes')->name('listeContacts');
Route::get('saisie/validation/{id}', 'ControllerCommande@formulaireValidation')->middleware('commandes')->name('formulaireValidation')->where('id', '[0-9]+');
Route::post('saisie/validation', 'ControllerCommande@validation')->middleware('commandes')->name('validation');
Route::get('saisie/rappel/{id}', 'ControllerCommande@rappel')->middleware('commandes')->name('rappel')->where('id', '[0-9]+');

// ############################# Routes pour l'interface de statistique #############################

Route::get('statistiques', 'ControllerStatistiques@vueStatistiques')->middleware('statistiques')->name('accueilAgglo');
Route::post('statistiques', 'ControllerStatistiques@updateVueStatistiques')->middleware('statistiques');

Route::get('statistiques/nc', 'ControllerStatistiques@vueNC')->middleware('statistiques')->name('ncAgglo');

Route::post('statistiques/nc', 'ControllerCommande@ajouterNcAgglo')->middleware('statistiques')->name('storeNcAgglo');
Route::post('statistiques/rapport', 'ControllerStatistiques@genererRapport')->middleware('statistiques')->name('generateReport');


Route::view('/test', 'test')->middleware('admin')->name('test');

Route::get('testTrois','ControllerAdmin@chartjs')->name('testTrois');


