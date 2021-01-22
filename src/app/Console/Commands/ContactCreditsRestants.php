<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ContactCreditsRestants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:contactcredits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoi de mail quand le nombre de crédits restants est trop faible';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        \App\Contacts::mailCreditsRestants(); // Essaye toutes les minutes d'envoyer des commandes si nécéssaire
    }
}
