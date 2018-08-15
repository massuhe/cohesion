<?php

namespace Tests\Unit;

use Tests\TestCase;
use Business\Finanzas\Models\Pago;
use Business\Finanzas\Services\PagoService;
use Business\Finanzas\Repositories\PagoRepository;

class PagoServiceTest extends TestCase
{

    public function testGetByMesCuota_RetornaVacio_DelRepository()
    {
        $pagoRepositoryMock = $this->getMockBuilder(PagoRepository::class)
                                ->setMethods(['getByMesCuota'])
                                ->getMock();

        $empty = array();
        $pagoRepositoryMock->expects($this->once())
                            ->method('getByMesCuota')
                            ->with($this->equalTo(2), $this->equalTo(4))
                            ->willReturn($empty);
        
        $pagoService = new PagoService($pagoRepositoryMock);
        $returned = $pagoService->getByMesCuota(2, 4);

        $this->assertTrue(is_array($returned));
        $this->assertEquals(0, count($returned));
    }

    public function testGetByMesCuota_RetornaNull_DelRepository()
    {
        $pagoRepositoryMock = $this->getMockBuilder(PagoRepository::class)
                                ->setMethods(['getByMesCuota'])
                                ->getMock();
        
        $pagoRepositoryMock->expects($this->once())
                            ->method('getByMesCuota')
                            ->with($this->equalTo(2), $this->equalTo(4))
                            ->willReturn(null);
        
        $pagoService = new PagoService($pagoRepositoryMock);
        $returned = $pagoService->getByMesCuota(2, 4);

        $this->assertNull($returned);
    }

    public function testGetByMesCuota_RetornaPagos_DelRepository()
    {
        $pagoRepositoryMock = $this->getMockBuilder(PagoRepository::class)
                                ->setMethods(['getByMesCuota'])
                                ->getMock();
        $pago1 = new Pago();
        $pago1->identificadorFicticio = 1111;
        $pago2 = new Pago();
        $pago2->identificadorFicticio = 2222;
        $arrayPagos = array($pago1, $pago2);
        $pagoRepositoryMock->expects($this->once())
                            ->method('getByMesCuota')
                            ->with($this->equalTo(2), $this->equalTo(4))
                            ->willReturn($arrayPagos);

        $pagoService = new PagoService($pagoRepositoryMock);
        $returned = $pagoService->getByMesCuota(2, 4);

        $this->assertTrue(is_array($returned));
        $this->assertEquals(2, count($returned));
        $this->assertEquals(1111, $returned[0]->identificadorFicticio);
        $this->assertEquals(2222, $returned[1]->identificadorFicticio);
    }

}
