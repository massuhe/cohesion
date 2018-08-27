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

    public function testStoreOrUpdate_SinMovimientosdelMes_BorraYGuardaVacio_RetornaVacioDelRepo()
    {
        $movimientoRepositoryMock = $this->getMockBuilder(MovimientoRepository::class)
                                ->setMethods(['deleteByMesAnio', 'storeMany', 'getWhereArray'])
                                ->getMock();
        $movimientoFactoryMock = $this->getMockBuilder(MovimientoFactory::class)
                                ->setMethods(['createMovimiento'])
                                ->getMock();
        
        $movimientoFactoryMock->expects($this->never())
                            ->method('createMovimiento');
        $mes = 5;   // Cualquier número de mes
        $anio = 2018;   // Cualquier número de año
        $mesYAnioArray = [
            ['mes', $mes],
            ['anio', $anio]
        ];
        $empty = collect([]);
        $anterioresVacio = collect([]);
        $movimientoRepositoryMock->expects($this->once())
                            ->method('deleteByMesAnio')
                            ->with($this->equalTo($mes), $this->equalTo($anio));
        $movimientoRepositoryMock->expects($this->once())
                            ->method('storeMany')
                            ->with($this->equalTo($empty));
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getWhereArray')
                            ->with($this->equalTo($mesYAnioArray))
                            ->willReturn($anterioresVacio);
                            
        $nuevosMovimientosVacio = array();
        $movimientoService = new MovimientoService($movimientoRepositoryMock, $movimientoFactoryMock);
        $returned = $movimientoService->storeOrUpdate($mes, $anio, $nuevosMovimientosVacio);

        $this->assertInstanceOf('Illuminate\Support\Collection', $returned);
        $this->assertEquals(0, $returned->count());
    }

    public function testStoreOrUpdate_SinMovimientosdelMes_BorraYGuardaVacio_RetornaMovimientosDelRepo()
    {
        $movimientoRepositoryMock = $this->getMockBuilder(MovimientoRepository::class)
                                ->setMethods(['deleteByMesAnio', 'storeMany', 'getWhereArray'])
                                ->getMock();
        $movimientoFactoryMock = $this->getMockBuilder(MovimientoFactory::class)
                                ->setMethods(['createMovimiento'])
                                ->getMock();
        
        $movimientoFactoryMock->expects($this->never())
                            ->method('createMovimiento');
        $mes = 5;   // Cualquier número de mes
        $anio = 2018;   // Cualquier número de año
        $mesYAnioArray = [
            ['mes', $mes],
            ['anio', $anio]
        ];
        $empty = collect([]);
        $movimiento1 = new Movimiento();
        $movimiento1->identificadorFicticio = 1111;
        $movimiento2 = new Movimiento();
        $movimiento2->identificadorFicticio = 2222;
        $arrayMovimientos = collect([$movimiento1, $movimiento2]);
        $movimientoRepositoryMock->expects($this->once())
                            ->method('deleteByMesAnio')
                            ->with($this->equalTo($mes), $this->equalTo($anio));
        $movimientoRepositoryMock->expects($this->once())
                            ->method('storeMany')
                            ->with($this->equalTo($empty));
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getWhereArray')
                            ->with($this->equalTo($mesYAnioArray))
                            ->willReturn($arrayMovimientos);
                            
        $nuevosMovimientosVacio = array();
        $movimientoService = new MovimientoService($movimientoRepositoryMock, $movimientoFactoryMock);
        $returned = $movimientoService->storeOrUpdate($mes, $anio, $nuevosMovimientosVacio);

        $this->assertInstanceOf('Illuminate\Support\Collection', $returned);
        $this->assertEquals(2, $returned->count());
        $movi1 = $returned[0];
        $this->assertInstanceOf('Business\Finanzas\Models\Movimiento', $movi1);
        $this->assertEquals(1111, $movi1->identificadorFicticio);
        $movi2 = $returned[1];
        $this->assertInstanceOf('Business\Finanzas\Models\Movimiento', $movi2);
        $this->assertEquals(2222, $movi2->identificadorFicticio);
    }

    public function testStoreOrUpdate_ConUnMovimiento_BorraDelMes_GuardaYRetornaElMovimiento()
    {
        $movimientoRepositoryMock = $this->getMockBuilder(MovimientoRepository::class)
                                ->setMethods(['deleteByMesAnio', 'storeMany', 'getWhereArray'])
                                ->getMock();
        $movimientoFactoryMock = $this->getMockBuilder(MovimientoFactory::class)
                                ->setMethods(['createMovimiento'])
                                ->getMock();
        
        $mes = 5;   // Cualquier número de mes
        $anio = 2018;   // Cualquier número de año
        $datosMovimiento1 = [
            'identificadorFicticio' => 1111,
            'importe' => 400
        ];
        $datosMovimientoFactoryParam1 = [
            'identificadorFicticio' => 1111,
            'importe' => 400,
            'mes' => $mes,
            'anio' => $anio
        ];
        $movimiento1 = new Movimiento();
        $movimiento1->identificadorFicticio = 1111;
        $movimientoFactoryMock->expects($this->once())
                            ->method('createMovimiento')
                            ->with($this->equalTo($datosMovimientoFactoryParam1))
                            ->willReturn($movimiento1);
        $mesYAnioArray = [
            ['mes', $mes],
            ['anio', $anio]
        ];
        $arrayMovimientos = collect([$movimiento1]);
        $movimientoRepositoryMock->expects($this->once())
                            ->method('deleteByMesAnio')
                            ->with($this->equalTo($mes), $this->equalTo($anio));
        $movimientoRepositoryMock->expects($this->once())
                            ->method('storeMany')
                            ->with($this->equalTo($arrayMovimientos));
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getWhereArray')
                            ->with($this->equalTo($mesYAnioArray))
                            ->willReturn($arrayMovimientos);
                            
        $nuevosMovimientos = array($datosMovimiento1);
        $movimientoService = new MovimientoService($movimientoRepositoryMock, $movimientoFactoryMock);
        $returned = $movimientoService->storeOrUpdate($mes, $anio, $nuevosMovimientos);

        $this->assertInstanceOf('Illuminate\Support\Collection', $returned);
        $this->assertEquals(1, $returned->count());
        $movi1 = $returned[0];
        $this->assertInstanceOf('Business\Finanzas\Models\Movimiento', $movi1);
        $this->assertEquals(1111, $movi1->identificadorFicticio);
    }

    public function testStoreOrUpdate_ConMovimientos_BorraDelMes_GuardaYRetornaMovimientos()
    {
        $movimientoRepositoryMock = $this->getMockBuilder(MovimientoRepository::class)
                                ->setMethods(['deleteByMesAnio', 'storeMany', 'getWhereArray'])
                                ->getMock();
        $movimientoFactoryMock = $this->getMockBuilder(MovimientoFactory::class)
                                ->setMethods(['createMovimiento'])
                                ->getMock();
        
        $mes = 5;   // Cualquier número de mes
        $anio = 2018;   // Cualquier número de año
        $datosMovimiento1 = [
            'identificadorFicticio' => 1111,
            'importe' => 400
        ];
        $datosMovimiento2 = [
            'identificadorFicticio' => 2222,
            'importe' => 500
        ];
        $datosMovimientoFactoryParam1 = [
            'identificadorFicticio' => 1111,
            'importe' => 400,
            'mes' => $mes,
            'anio' => $anio
        ];
        $datosMovimientoFactoryParam2 = [
            'identificadorFicticio' => 2222,
            'importe' => 500,
            'mes' => $mes,
            'anio' => $anio
        ];
        $movimiento1 = new Movimiento();
        $movimiento1->identificadorFicticio = 1111;
        $movimiento2 = new Movimiento();
        $movimiento2->identificadorFicticio = 2222;
        $movimientoFactoryMock->expects($this->exactly(2))
                            ->method('createMovimiento')
                            ->withConsecutive([$this->equalTo($datosMovimientoFactoryParam1)], [$this->equalTo($datosMovimientoFactoryParam2)])
                            ->will($this->onConsecutiveCalls($movimiento1, $movimiento2));
        $mesYAnioArray = [
            ['mes', $mes],
            ['anio', $anio]
        ];
        $arrayMovimientos = collect([$movimiento1, $movimiento2]);
        $movimientoRepositoryMock->expects($this->once())
                            ->method('deleteByMesAnio')
                            ->with($this->equalTo($mes), $this->equalTo($anio));
        $movimientoRepositoryMock->expects($this->once())
                            ->method('storeMany')
                            ->with($this->equalTo($arrayMovimientos));
        $movimientoRepositoryMock->expects($this->once())
                            ->method('getWhereArray')
                            ->with($this->equalTo($mesYAnioArray))
                            ->willReturn($arrayMovimientos);
                            
        $nuevosMovimientos = array($datosMovimiento1, $datosMovimiento2);
        $movimientoService = new MovimientoService($movimientoRepositoryMock, $movimientoFactoryMock);
        $returned = $movimientoService->storeOrUpdate($mes, $anio, $nuevosMovimientos);

        $this->assertInstanceOf('Illuminate\Support\Collection', $returned);
        $this->assertEquals(2, $returned->count());
        $movi1 = $returned[0];
        $this->assertInstanceOf('Business\Finanzas\Models\Movimiento', $movi1);
        $this->assertEquals(1111, $movi1->identificadorFicticio);
        $movi2 = $returned[1];
        $this->assertInstanceOf('Business\Finanzas\Models\Movimiento', $movi2);
        $this->assertEquals(2222, $movi2->identificadorFicticio);
    }

}
