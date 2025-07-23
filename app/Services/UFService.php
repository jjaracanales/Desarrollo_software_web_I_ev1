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
                // Configuración común para las peticiones HTTP
                $httpConfig = [
                    'timeout' => 15,
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
                        'Accept' => 'application/json',
                        'Accept-Language' => 'es-ES,es;q=0.9,en;q=0.8'
                    ]
                ];

                // Intentar con API de Santa.cl
                $result = $this->trySantaAPI($httpConfig);
                if ($result['success']) {
                    return $result;
                }

                // Intentar con API de Gael.cloud
                $result = $this->tryGaelAPI($httpConfig);
                if ($result['success']) {
                    return $result;
                }

                // Intentar con API del Banco Central
                $result = $this->tryBancoCentralAPI($httpConfig);
                if ($result['success']) {
                    return $result;
                }

                // Intentar con API de Mindicador
                $result = $this->tryMindicadorAPI($httpConfig);
                if ($result['success']) {
                    return $result;
                }
                
            } catch (Exception $e) {
                // Log detallado del error para debugging
                logger()->error('Error al obtener valor UF: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
            
            // Valor de respaldo si todas las APIs fallan
            logger()->warning('Usando valor de respaldo para UF');
            return [
                'success' => true,
                'value' => '39.224,63',
                'date' => now()->format('Y-m-d'),
                'source' => 'Sistema Interno (Respaldo)'
            ];
        // });
    }

    /**
     * Intenta obtener el valor de la UF desde la API de Santa.cl
     */
    private function trySantaAPI($config)
    {
        try {
            $response = Http::withHeaders($config['headers'])
                           ->timeout($config['timeout'])
                           ->get('https://api.santa.cl/uf');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['success']) && $data['success'] && isset($data['data']['uf'])) {
                    $ufValue = $data['data']['uf'];
                    $date = $data['data']['date'] ?? now()->format('Y-m-d');
                    
                    return [
                        'success' => true,
                        'value' => number_format($ufValue, 2, ',', '.'),
                        'date' => $date,
                        'source' => 'API Santa.cl'
                    ];
                }
            }
            
            logger()->warning('API Santa.cl falló', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
        } catch (Exception $e) {
            logger()->error('Error con API Santa.cl: ' . $e->getMessage());
        }
        
        return ['success' => false];
    }

    /**
     * Intenta obtener el valor de la UF desde la API de Gael.cloud
     */
    private function tryGaelAPI($config)
    {
        try {
            $response = Http::withHeaders($config['headers'])
                           ->timeout($config['timeout'])
                           ->get('https://api.gael.cloud/general/public/monedas/uf');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data[0]['Valor'])) {
                    $ufValue = (float) str_replace(['.', ','], ['', '.'], $data[0]['Valor']);
                    
                    return [
                        'success' => true,
                        'value' => number_format($ufValue, 2, ',', '.'),
                        'date' => $data[0]['Fecha'] ?? now()->format('Y-m-d'),
                        'source' => 'API Gael.cloud'
                    ];
                }
            }
            
            logger()->warning('API Gael.cloud falló', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
        } catch (Exception $e) {
            logger()->error('Error con API Gael.cloud: ' . $e->getMessage());
        }
        
        return ['success' => false];
    }

    /**
     * Intenta obtener el valor de la UF desde la API del Banco Central
     */
    private function tryBancoCentralAPI($config)
    {
        try {
            $date = now()->format('Y-m-d');
            $response = Http::withHeaders($config['headers'])
                           ->timeout($config['timeout'])
                           ->get("https://api.sbif.cl/api-sbifv3/recursos_api/uf?apikey=9c84db4d447c80fd4c7267c2d6c5c5c5&formato=json&fecha={$date}");
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['UFs'][0]['Valor'])) {
                    $ufValue = (float) str_replace(',', '.', $data['UFs'][0]['Valor']);
                    
                    return [
                        'success' => true,
                        'value' => number_format($ufValue, 2, ',', '.'),
                        'date' => $date,
                        'source' => 'API Banco Central'
                    ];
                }
            }
            
            logger()->warning('API Banco Central falló', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
        } catch (Exception $e) {
            logger()->error('Error con API Banco Central: ' . $e->getMessage());
        }
        
        return ['success' => false];
    }

    /**
     * Intenta obtener el valor de la UF desde la API de Mindicador
     */
    private function tryMindicadorAPI($config)
    {
        try {
            $response = Http::withHeaders($config['headers'])
                           ->timeout($config['timeout'])
                           ->get('https://mindicador.cl/api/uf');
            
            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['serie'][0]['valor'])) {
                    $ufValue = $data['serie'][0]['valor'];
                    
                    return [
                        'success' => true,
                        'value' => number_format($ufValue, 2, ',', '.'),
                        'date' => $data['serie'][0]['fecha'] ?? now()->format('Y-m-d'),
                        'source' => 'API Mindicador'
                    ];
                }
            }
            
            logger()->warning('API Mindicador falló', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            
        } catch (Exception $e) {
            logger()->error('Error con API Mindicador: ' . $e->getMessage());
        }
        
        return ['success' => false];
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
} 