<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ContactCommande extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:contact';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envoi de mail ou messages vocaux pour les commandes si nécéssaire';

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
        \App\Contacts::commandeContact();
    }
}
