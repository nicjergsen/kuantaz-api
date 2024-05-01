<?php

namespace Tests\Unit;

use App\Services\KuantazApiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GetFilteredBenefitsTest extends TestCase
{
    /** @test */
    public function it_returns_filtered_benefits_as_collection()
    {
        $service = new KuantazApiService();
        $response = $service->getFilteredBenefits();
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $response);
    }
}
