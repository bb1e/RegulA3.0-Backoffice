<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;
use PHPUnit\Framework\Assert as PHPUnit;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register Dusk's browser macros.
     *
     * @return void
     */
    public function boot()
    {
      Browser::macro("testEnterLogin", function () {
	  $this->visit('/')
	    ->type('email','camila.simoes@mail.pt')
	    ->type('password','123123123')
	    ->press('LOGIN')
	    ->assertRouteIs('default')
	    ->assertSee('Página Principal');
	  return $this;
	});
      Browser::macro("assertElementsCountIs", function ($count,$selector) {
	  PHPUnit::assertEquals( $count, count($this->elements( $selector )));
	  return $this;
	});
      Browser::macro("reduce", function($collection, $fn) {
	  $collection->reduce($fn,$this);
	  return $this;
	});
    }
}
