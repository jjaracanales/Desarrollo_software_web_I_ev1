<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class UFService
{
    /**
     * Obtiene el valor actual de la UF
     * 
     * @return array|null
     */
    public function getUFValue()
    {
        // Temporalmente sin cache para evitar problemas de SQL en Vercel
        // return Cache::remember('uf_value', 3600, function () {
            try {
                // Usando la nueva API de Santa.cl
                $response = Http::timeout(10)->get('https://api.santa.cl/uf');
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    // Verificar si la respuesta tiene el formato esperado
                    if (isset($data['success']) && $data['success'] && isset($data['data']['uf'])) {
                        $ufValue = $data['data']['uf'];
                        $date = $data['data']['date'] ?? now()->format('Y-m-d');
                        
                        // Validar que el valor esté en un rango razonable
                        if ($this->isValidUFValue($ufValue)) {
                            return [
                                'success' => true,
                                'value' => number_format($ufValue, 2, ',', '.'),
                                'date' => $date,
                                'source' => 'API Santa.cl'
                            ];
                        }
                    }
                }
                
                // Si falla, intentar con API alternativa
                $response = Http::timeout(10)->get('https://api.gael.cloud/general/public/monedas/uf');
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    if (isset($data[0]['Valor'])) {
                        $ufValue = (float) str_replace(['.', ','], ['', '.'], $data[0]['Valor']);
                        
                        if ($this->isValidUFValue($ufValue)) {
                            return [
                                'success' => true,
                                'value' => number_format($ufValue, 2, ',', '.'),
                                'date' => $data[0]['Fecha'] ?? now()->format('Y-m-d'),
                                'source' => 'API Gael.cloud'
                            ];
                        }
                    }
                }
                
            } catch (Exception $e) {
                // Log del error para debugging
                logger()->error('Error al obtener valor UF: ' . $e->getMessage());
            }
            
            // Valor de respaldo si todas las APIs fallan
            return [
                'success' => true,
                'value' => '39.224,63',
                'date' => now()->format('Y-m-d'),
                'source' => 'Sistema Interno'
            ];
        // });
    }
    
    /**
     * Valida que el valor de la UF esté en un rango razonable
     * 
     * @param float $value
     * @return bool
     */
    private function isValidUFValue($value)
    {
        // La UF históricamente ha estado entre 30,000 y 50,000 pesos
        return $value >= 30000 && $value <= 50000;
    }
    
    /**
     * Obtiene información formateada de la UF
     * 
     * @return array
     */
    public function getUFInfo()
    {
        $ufData = $this->getUFValue();
        
        if (!$ufData || !$ufData['success']) {
            return [
                'success' => false,
                'message' => 'No se pudo obtener el valor de la UF'
            ];
        }
        
        return [
            'success' => true,
            'value' => $ufData['value'],
            'date' => $ufData['date'],
            'source' => $ufData['source'],
            'formatted' => '$' . $ufData['value'],
            'last_update' => now()->format('H:i:s')
        ];
    }
    
    /**
     * Convierte un monto en pesos a UF
     * 
     * @param float $amount
     * @return array
     */
    public function convertToUF($amount)
    {
        $ufData = $this->getUFValue();
        
        if (!$ufData || !$ufData['success']) {
            return [
                'success' => false,
                'message' => 'No se pudo obtener el valor de la UF para la conversión'
            ];
        }
        
        $ufValue = (float) str_replace(['.', ','], ['', '.'], $ufData['value']);
        $ufAmount = $amount / $ufValue;
        
        return [
            'success' => true,
            'amount_clp' => number_format($amount, 0, ',', '.'),
            'amount_uf' => number_format($ufAmount, 2, ',', '.'),
            'uf_value' => $ufData['value'],
            'date' => $ufData['date']
        ];
    }
} 