<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{

    private $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }


    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testOAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao)
    {

        // Act - When
        $this->leiloeiro->avalia($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        // Assert - Then
        self::assertEquals(3000, $maiorValor);
    }


    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testOAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao)
    {

        // Act - When
        $this->leiloeiro->avalia($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        // Assert - Then
        self::assertEquals(1700, $menorValor);
    }

    /**
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testOAvaliadorDeveBuscarOsTresMaioresValores(Leilao $leilao)
    {
        $this->leiloeiro->avalia($leilao);

        $maioresLances = $this->leiloeiro->getMaioresLances();

        self::assertCount(3, $maioresLances);
        self::assertEquals(3000, $maioresLances[0]->getValor());
        self::assertEquals(2500, $maioresLances[1]->getValor());
        self::assertEquals(2000, $maioresLances[2]->getValor());
    }

    public function leilaoEmOrdemCrescente(): array
    {

        $leilao = new Leilao('Fiat 147 0km');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($jorge, 3000));

        return ['ordem crescente' =>[$leilao]];
    }

    public function leilaoEmOrdemDecrescente(): array
    {

        $leilao = new Leilao('Fiat 147 0km');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($jorge, 3000));
        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));

        return ['ordem decrescente' =>[$leilao]];
    }

    public function leilaoEmOrdemAleatoria(): array
    {


        $leilao = new Leilao('Fiat 147 0km');
        $joao = new Usuario('João');
        $maria = new Usuario('Maria');
        $ana = new Usuario('Ana');
        $jorge = new Usuario('Jorge');

        $leilao->recebeLance(new Lance($jorge, 3000));
        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($ana, 1700));
        $leilao->recebeLance(new Lance($maria, 2500));

        return ['ordem aleatória' => [$leilao]];
    }
}
