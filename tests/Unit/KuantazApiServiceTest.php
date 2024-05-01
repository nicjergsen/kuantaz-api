<?php

namespace Tests\Unit;

use App\Services\KuantazApiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Support\Collection;

class KuantazApiServiceTest extends TestCase
{
/**
     * @test
     */
    public function test_it_can_get_benefits_from_api()
    {
        $response = [
            'data' => [
                ['id_programa' => 147, 'monto' => 40656, 'fecha_recepcion' => '09/11/2023', 'fecha' => '2023-11-09'],
                ['id_programa' => 147, 'monto' => 60000, 'fecha_recepcion' => '10/10/2023', 'fecha' => '2023-10-10']
            ]
        ];

        $httpClient = $this->mockHttpClient($response);
        $kuantazApiService = new KuantazApiService($httpClient);
        $benefits = $kuantazApiService->getBenefits();

        $this->assertInstanceOf(Collection::class, $benefits);
        $this->assertEquals(2, $benefits->count());
        $this->assertEquals(147, $benefits[0]['id_programa']);
        $this->assertEquals(40656, $benefits[0]['monto']);
        $this->assertEquals('09/11/2023', $benefits[0]['fecha_recepcion']);
        $this->assertEquals('2023-11-09', $benefits[0]['fecha']);
    }

    private function mockHttpClient($response)
    {
        return \Http::fake([
            'https://run.mocky.io/v3/399b4ce1-5f6e-4983-a9e8-e3fa39e1ea71' => \Http::response($response)
        ]);
    }
}
