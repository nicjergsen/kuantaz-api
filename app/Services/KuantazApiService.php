<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;
use Illuminate\Http\Client\RequestException;
use Carbon\Carbon;

class KuantazApiService
{
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiBaseUrl = config('services.kuantaz.api_url');
    }

    public function getBenefits(): Collection
    {
        return $this->callApi('399b4ce1-5f6e-4983-a9e8-e3fa39e1ea71');
    }

    public function getFilters(): Collection
    {
        return $this->callApi('06b8dd68-7d6d-4857-85ff-b58e204acbf4');
    }

    public function getRecords(): Collection
    {
        return $this->callApi('c7a4777f-e383-4122-8a89-70f29a6830c0');
    }

    private function callApi($suffix): Collection
    {
        try {
            $response = Http::get($this->apiBaseUrl . $suffix);
            
            if ($response->successful()) {
                return collect($response->json()['data']);
            } else {
                \Log::error('Error al obtener datos de la API: ' . $response->status());
                return collect([]);
            }
        } catch (RequestException $e) {
            \Log::error('Error al obtener datos de la API: ' . $e->getMessage());
            return collect([]);
        }
    }

    public function getFilteredBenefits(){
        try {
            $benefits = $this->getBenefits();
            $filters = $this->getFilters();
            $records = $this->getRecords();

            if (!$benefits->count() || !$filters->count() || !$records->count()) {
                \Log::error('Error al obtener datos de la API: No se pudieron obtener los datos');
                return response()->json(['message' => 'Error al obtener datos de la API'], 500);
            }

            $filteredBenefits = $benefits->filter(function ($benefit) use ($filters) {
                $filter = $filters->firstWhere('id_programa', $benefit['id_programa']);
                return $benefit['monto'] >= $filter['min'] && $benefit['monto'] <= $filter['max'];
            })
            ->map(function ($benefit) use ($filters, $records) {
                $filter = $filters->firstWhere('id_programa', $benefit['id_programa']);
                $record = $records->firstWhere('id_programa', $benefit['id_programa']);
                $year = Carbon::parse($benefit['fecha_recepcion'])->format('Y');
                return array_merge($benefit, ['ano' => $year, 'view' => true, 'ficha' => $record]);
            })
            ->groupBy('ano')
            ->map(function ($benefitsPerYear) {
                return [
                    'year' => $benefitsPerYear->first()['ano'],
                    'num' => $benefitsPerYear->count(),
                    'monto_total_por_anio' => $benefitsPerYear->sum('monto'),
                    'beneficios' => $benefitsPerYear
                ];
            })
            ->sortKeysDesc()
            ->values();

            return $filteredBenefits;
        } catch (\Exception $e) {
            \Log::error('Error al obtener datos de la API: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron obtener los datos. Error: ' . $e->getMessage()], 500);
        }
    }
}
