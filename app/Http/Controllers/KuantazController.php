<?php

namespace App\Http\Controllers;

use App\Services\KuantazApiService;
use Illuminate\Http\Request;

/**
* @OA\Info(
*             title="API de Beneficios (filtrados)", 
*             version="1.0",
*             description="Información de la API de Beneficios (filtrados)"
* )
*
* @OA\Server(url="http://127.0.0.1:8000")
*/

class KuantazController extends Controller
{
    protected $kuantazApiService;

    public function __construct(KuantazApiService $kuantazApiService)
    {
        $this->kuantazApiService = $kuantazApiService;
    }

    /**
     * Obtiene un listado de Beneficios por año
     *
     * @OA\Get(
     *     path="/api/beneficios-por-anio",
     *     tags={"Beneficios"},
     *     summary="Obtiene un listado de Beneficios por año",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de Beneficios por año",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="code",
     *                 type="integer",
     *                 example=200
     *             ),
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="year",
     *                         type="string",
     *                         example="2023"
     *                     ),
     *                     @OA\Property(
     *                         property="num",
     *                         type="integer",
     *                         example=8
     *                     ),
     *                     @OA\Property(
     *                         property="monto_total_por_anio",
     *                         type="integer",
     *                         example=295608
     *                     ),
     *                     @OA\Property(
     *                         property="beneficios",
     *                         type="array",
     *                         @OA\Items(
     *                             @OA\Property(
     *                                 property="id_programa",
     *                                 type="integer",
     *                                 example=147
     *                             ),
     *                             @OA\Property(
     *                                 property="monto",
     *                                 type="integer",
     *                                 example=40656
     *                             ),
     *                             @OA\Property(
     *                                 property="fecha_recepcion",
     *                                 type="string",
     *                                 example="09/11/2023"
     *                             ),
     *                             @OA\Property(
     *                                 property="fecha",
     *                                 type="string",
     *                                 example="2023-11-09"
     *                             ),
     *                             @OA\Property(
     *                                 property="ano",
     *                                 type="string",
     *                                 example="2023"
     *                             ),
     *                             @OA\Property(
     *                                 property="view",
     *                                 type="boolean",
     *                                 example=true
     *                             ),
     *                             @OA\Property(
     *                                 property="ficha",
     *                                 type="object",
     *                                 @OA\Property(
     *                                     property="id",
     *                                     type="integer",
     *                                     example=922
     *                                 ),
     *                                 @OA\Property(
     *                                     property="nombre",
     *                                     type="string",
     *                                     example="Emprende"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="id_programa",
     *                                     type="integer",
     *                                     example=147
     *                                 ),
     *                                 @OA\Property(
     *                                     property="url",
     *                                     type="string",
     *                                     example="emprende"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="categoria",
     *                                     type="string",
     *                                     example="trabajo"
     *                                 ),
     *                                 @OA\Property(
     *                                     property="descripcion",
     *                                     type="string",
     *                                     example="Fondos concursables para nuevos negocios"
     *                                 ),
     *                             ),
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error al obtener datos de la API",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="error",
     *                 type="string",
     *                 example="No se pudieron obtener los datos. Error: Error message"
     *             )
     *         )
     *     )
     * )
     */
    public function getBenefitsPerYear()
    {
        try {
            $filteredBenefits = $this->kuantazApiService->getFilteredBenefits();

            return response()->json([
                'code' => 200,
                'success' => true,
                'data' => $filteredBenefits
            ]);

        } catch(\Exception $e){
            \Log::error('No se pudieron obtener los datos. Error: ' . $e->getMessage());
            return response()->json(['error' => 'No se pudieron obtener los datos. Error: ' . $e->getMessage()], 500);
        }
    
    }

}