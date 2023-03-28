<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Str;


class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
	      ->assertRouteIs('login');
        });
    }

    public function testLoginEmailPassword()
    {
        $this->browse(function (Browser $browser) {
	    $browser->testEnterLogin()
	      // ->assertAuthenticated()
	      ->clickLink('Logout')
	      ->assertRouteIs('login')
	      ->assertGuest();
	  });
    }

    public function testChatSendMessage()
    {
      $this->browse(function (Browser $browser) {
	  $msg = 'mensagem de teste' . Str::random(4);
	  $browser->testEnterLogin()
	    ->clickLink('Chat')
	    ->assertRouteIs('chat')
	    ->clickLink('Pai Demo')
	    ->click('input[name="message"]')->pause(200) // without this it was sometimes leaving first characters out
	    ->type('message', $msg)
	    ->press('#btn-enviar')
	    ->assertInputValue('message', '') // clears message after send
	    ->assertSee($msg) //can see message displayed elsewhere
	    ->clickLink('Logout');
        });
    }

	public function testChildrenManagement()
	{
	  $this->browse(function (Browser $browser) {
	      $browser->testEnterLogin()
		->clickLink("Crianças") 
		->screenshot("criancas-list")
		->click("form a") //click first child profile
		// não é possivel fazer routeIs pois precisa de o id da criança como parametro
		//perfil da crianca
		->clickLink("Dashboard")
		// dashboard da crianca
		->assertSee("Feedback De Estratégias") // table titles
		->assertSee("Relatórios Semanais")
		->assertSee("Histórico de relatórios")
		->assertSee("Histórico de comentários de relatórios semanais")
		->assertElementsCountIs(3,"table") // the three tables appear
		->screenshot("crianca-dashboard")
		->click("table a")//->clickLink("Detalhes") // detalhes do feedback
		->assertSee("Nome da estratégia")
		->assertSee("Data do feedback")
		->assertSee("Conseguiu realizar a estratégia?")
		->assertSee("Total de feedback recebido")
		->assertSee("Media do feedback")
		->back()
		//dashboard da criança -> gráficos de evolução
		->clickLink(" Ver gráficos de evolução")
		->assertSee("Gráficos de evolução")
		->assertVisible(".apexcharts-svg")
		->back()
		->back()
		//perfil da criança
		->clickLink("Avaliar")
		->reduce(collect([1,2,3,4,5,6,7]),
			 function($browser,$n) {
			   return $browser->select("av".$n,($n % 2 == 0) ? "Hipo-reativo" : "Hiper-reativo"); //alternar entre hipo e hiper
			 })//preencher e avaliar
		->type("comentario","teste de avaliação ". Str::random(4))
		->scrollIntoView("button[type=submit]")->press("Confirmar")
		->assertSee("Criança avaliada com sucesso.")
		->clickLink('Logout');
        });
    }

}
