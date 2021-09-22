<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ScrapeTheHDB extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @test
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('https://wfm-hdb.se.msdp.ericsson.net/hdb/')
                ->waitForLink('Log On')
                ->type('login', 'emrlddr')
                ->type('passwd', 'm@2013.com')
                ->clickLink('Log On')
                ->waitForReload()
                ->waitFor('fame[name=main]')
                ->withinFrame('frame[name=main]', function($browser){
                    $browser->pause(3000);
                    $browser->keys('input[name="userId"]', 'emrlddr')
                        ->keys('input[name="password"]', 'm@2013.com')
                    >press('button[type="submit"');
                });
            // ->type('userId', 'emrlddr')
            //->type('@username', 'm@2013.com');
            //->press('Login');
        });
    }
}
