<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UFService
{
    /**
     * Obtiene el valor de la UF del día desde una API externa
     * 
     * @return array|null
     */
    public function getUFValue()
    {
        // Cache por 1 hora para evitar demasiadas llamadas a la API
        return Cache::remember('uf_value', 3600, function () {
            try {
                // Usando la nueva API de Santa.cl
                $response = Http::timeout(10)->get('https://api.santa.cl/uf');
                
                if ($response->successful()) {
                    $data = $response->json();
                    
                    // Verificar si la respuesta tiene el formato esperado
                    if (isset($data['success']) && $data['success'] && isset($data['data']['uf'])) {
                        $ufValue = $data['data']['uf'];
                        $date = $data['data']['date'] ?? now()->format('Y-m-d');
                        $source = $data['data']['source'] ?? 'API Santa.cl';
                        
                        // Validar que el valor sea razonable (entre 30,000 y 50,000)
                        if ($ufValue >= 30000 && $ufValue <= 50000) {
                            return [
                                'success' => true,
                                'value' => $ufValue,
                                'date' => $date,
                                'source' => 'Sistema Interno'
                            ];
                        } else {
                            // Si el valor no es razonable, usar valor simulado
                            return [
                                'success' => false,
                                'error' => 'Valor de UF fuera del rango esperado',
                                'value' => 39224.63, // Valor realista de la UF
                                'date' => $date,
                                'source' => 'Sistema Interno',
                                'simulated' => true
                            ];
                        }
                    }
                    
                    // Formato anterior de la API
                    if (isset($data['uf']) && isset($data['today'])) {
                        $ufValue = $data['uf'];
                        $today = \Carbon\Carbon::parse($data['today'])->format('Y-m-d');
                        
                        // Validar que el valor sea razonable
                        if ($ufValue >= 30000 && $ufValue <= 50000) {
                            return [
                                'success' => true,
                                'value' => $ufValue,
                                'date' => $today,
                                'source' => 'Sistema Interno'
                            ];
                        } else {
                            return [
                                'success' => false,
                                'error' => 'Valor de UF fuera del rango esperado',
                                'value' => 39224.63,
                                'date' => $today,
                                'source' => 'Sistema Interno',
                                'simulated' => true
                            ];
                        }
                    }
                    
                                    return [
                    'success' => false,
                    'error' => 'Formato de respuesta inesperado',
                    'date' => now()->format('Y-m-d'),
                    'source' => 'Sistema Interno'
                ];
                }
                
                return [
                    'success' => false,
                    'error' => 'No se pudo obtener el valor de la UF',
                    'date' => now()->format('Y-m-d'),
                    'source' => 'Sistema Interno'
                ];
                
            } catch (\Exception $e) {
                // En caso de error, devolver un valor simulado para demostración
                return [
                    'success' => false,
                    'error' => 'Error al conectar con la API: ' . $e->getMessage(),
                    'value' => 39224.63, // Valor realista de la UF actual
                    'date' => now()->format('Y-m-d'),
                    'source' => 'Sistema Interno',
                    'simulated' => true
                ];
            }
        });
    }
    
    /**
     * Obtiene el valor de la UF formateado para mostrar
     * 
     * @return string
     */
    public function getFormattedUFValue()
    {
        $ufData = $this->getUFValue();
        
        if ($ufData['success'] && isset($ufData['value'])) {
            return '$' . number_format($ufData['value'], 2, ',', '.');
        }
        
        if (isset($ufData['simulated']) && $ufData['simulated']) {
            return '$' . number_format($ufData['value'], 2, ',', '.') . ' (Simulado)';
        }
        
        return 'No disponible';
    }
    
    /**
     * Obtiene información completa de la UF
     * 
     * @return array
     */
    public function getUFInfo()
    {
        $ufData = $this->getUFValue();
        
        return [
            'value' => $ufData['value'] ?? null,
            'formatted_value' => $this->getFormattedUFValue(),
            'date' => $ufData['date'] ?? now()->format('Y-m-d'),
            'source' => $ufData['source'] ?? 'Sistema Interno',
            'is_simulated' => $ufData['simulated'] ?? false,
            'success' => $ufData['success'] ?? false,
            'error' => $ufData['error'] ?? null
        ];
    }
} 