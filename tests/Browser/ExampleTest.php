<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{

    public function testBasicExample()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('https://wfm-hdb.se.msdp.ericsson.net/hdb/')
               ->waitForLink('Log On')
               ->type('login', 'emrlddr')
               ->type('password', 'm@2013.com')
               ->click('loginBtn')
               ->waitForReload()
                ->driver->switchTo()->frame(2)
                ->type('userId', 'emrlddr')
                ->type('passwd', 'm@2013.com')
                ->press('Login');
            //->type('@username', 'm@2013.com');
            // ->type('userId', 'emrlddr')

        });
    }
}

