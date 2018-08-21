<?php

namespace Tests\Unit;

use Tests\TestCase;
use Business\Finanzas\Services\MovimientoService;
use Business\Finanzas\Repositories\MovimientoRepository;
use Business\Finanzas\Factories\MovimientoFactory;
use Business\Finanzas\Models\Movimiento;
use ErrorException;

class MovimientoServiceTest extends TestCase
{

    public function testFindOrReturnLatest_RetornaMovimientosDelMes_DelRepository()
    {
        $movimientoRepositoryMock = $this->getMockBuilder(MovimientoRepository::class)
                                ->setMethods(['getWhereArray', 'getLatestOlderThan'])
                                ->getMock();
        $movimientoFactoryMock = $this->getMockBuilder(MovimientoFactory::class)
                                ->getMock();

        $movimiento1 = new Movimiento();
        $movimiento1->identificadorFicticio = 1111;
        $movimiento2 = new Movimiento();
        $movimiento2->identificadorFicticio = 2222;
        $arrayMovimientos = array($movimiento1, $movimiento2);
        $mes = 5;   // Cualquier número de mes
        $anio = 2018;   // Cualquier número de año
        $mesYAnioArray = [
            ['mes', $mes],
            ['anio', $anio]
        ];
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getWhereArray')
                            ->with($this->equalTo($mesYAnioArray))
                            ->willReturn($arrayMovimientos);
        $movimientoRepositoryMock->expects($this->never())
                            ->method('getLatestOlderThan');
        
        $movimientoService = new MovimientoService($movimientoRepositoryMock, $movimientoFactoryMock);
        $returned = $movimientoService->findOrReturnLatest($mes, $anio);

        $this->assertTrue(is_array($returned));
        $this->assertEquals(2, count($returned));
        $this->assertEquals(1111, $returned[0]->identificadorFicticio);
        $this->assertEquals(2222, $returned[1]->identificadorFicticio);
    }

    public function testFindOrReturnLatest_SinMovimientosdelMes_RetornaMovimientosAnteriores()
    {
        $movimientoRepositoryMock = $this->getMockBuilder(MovimientoRepository::class)
                                ->setMethods(['getWhereArray', 'getLatestOlderThan'])
                                ->getMock();
        $movimientoFactoryMock = $this->getMockBuilder(MovimientoFactory::class)
                                ->getMock();
        
        $mes = 5;   // Cualquier número de mes
        $anio = 2018;   // Cualquier número de año
        $mesYAnioArray = [
            ['mes', $mes],
            ['anio', $anio]
        ];
        $empty = array();
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getWhereArray')
                            ->with($this->equalTo($mesYAnioArray))
                            ->willReturn($empty);
        $movimiento1 = new Movimiento();
        $movimiento1->identificadorFicticio = 1111;
        $movimiento2 = new Movimiento();
        $movimiento2->identificadorFicticio = 2222;
        $arrayMovimientos = array($movimiento1, $movimiento2);
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getLatestOlderThan')
                            ->with($this->equalTo($mes), $this->equalTo($anio))
                            ->willReturn($arrayMovimientos);
        
        $movimientoService = new MovimientoService($movimientoRepositoryMock, $movimientoFactoryMock);
        $returned = $movimientoService->findOrReturnLatest($mes, $anio);

        $this->assertTrue(is_array($returned));
        $this->assertEquals(2, count($returned));
        $this->assertEquals(1111, $returned[0]->identificadorFicticio);
        $this->assertEquals(2222, $returned[1]->identificadorFicticio);
    }

    public function testFindOrReturnLatest_SinMovimientosdelMes_RetornaMovimientosAnterioresVacio()
    {
        $movimientoRepositoryMock = $this->getMockBuilder(MovimientoRepository::class)
                                ->setMethods(['getWhereArray', 'getLatestOlderThan'])
                                ->getMock();
        $movimientoFactoryMock = $this->getMockBuilder(MovimientoFactory::class)
                                ->getMock();
        
        $mes = 5;   // Cualquier número de mes
        $anio = 2018;   // Cualquier número de año
        $mesYAnioArray = [
            ['mes', $mes],
            ['anio', $anio]
        ];
        $empty = array();
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getWhereArray')
                            ->with($this->equalTo($mesYAnioArray))
                            ->willReturn($empty);
        $empty2 = array();
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getLatestOlderThan')
                            ->with($this->equalTo($mes), $this->equalTo($anio))
                            ->willReturn($empty2);
        
        $movimientoService = new MovimientoService($movimientoRepositoryMock, $movimientoFactoryMock);
        $returned = $movimientoService->findOrReturnLatest($mes, $anio);

        $this->assertTrue(is_array($returned));
        $this->assertEquals(0, count($returned));
    }

    // En realidad este test no se debería implementar. Pero queda como ejemplo del lanzamiento esperado de excepciones.
    // Si tenemos como regla que el repositorio no debería devolver null, este test no tendría sentido.
    // Y en cambio, los unit tests del repositorio deberían probar que el repositorio no devuelva nunca null.
    public function testFindOrReturnLatest_NullDelRepo_LanzaExcepcion()
    {
        $this->expectException(ErrorException::class);
        $movimientoRepositoryMock = $this->getMockBuilder(MovimientoRepository::class)
                                ->setMethods(['getWhereArray', 'getLatestOlderThan'])
                                ->getMock();
        $movimientoFactoryMock = $this->getMockBuilder(MovimientoFactory::class)
                                ->getMock();
        
        $mes = 5;   // Cualquier número de mes
        $anio = 2018;   // Cualquier número de año
        $mesYAnioArray = [
            ['mes', $mes],
            ['anio', $anio]
        ];
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getWhereArray')
                            ->with($this->equalTo($mesYAnioArray))
                            ->willReturn(null);
        $movimientoRepositoryMock->expects($this->never())
                            ->method('getLatestOlderThan');
        
        $movimientoService = new MovimientoService($movimientoRepositoryMock, $movimientoFactoryMock);
        $movimientoService->findOrReturnLatest($mes, $anio);
    }

}
