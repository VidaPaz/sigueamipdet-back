<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class MaximoProcess extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function upload_report_maximo()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://190.144.215.103/maximo/ui/login')
                    ->type('username','didier');
        });
    }
}
