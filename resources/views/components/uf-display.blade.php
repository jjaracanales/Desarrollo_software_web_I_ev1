@php
    use App\Services\UFService;
    $ufService = new UFService();
    $ufInfo = $ufService->getUFInfo();
@endphp

<div class="ant-card" style="border: 1px solid #91d5ff; animation: slideInLeft 0.6s ease;">
    <div class="ant-card-head" style="background: linear-gradient(135deg, #e6f7ff 0%, #bae7ff 100%); border-bottom: 1px solid #91d5ff;">
        <div class="ant-card-head-wrapper">
            <div class="ant-card-head-title">
                <i class="fas fa-chart-line" style="margin-right: 8px; color: #1890ff; animation: pulse 2s infinite;"></i>
                Valor UF del Día
            </div>
        </div>
    </div>
    <div class="ant-card-body" style="text-align: center; background: linear-gradient(135deg, #fafcff 0%, #f0f8ff 100%);">
        @if($ufInfo['success'])
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <div class="ant-statistic" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: 1px solid #e6f7ff; border-radius: 12px; padding: 20px;">
                        <div class="ant-statistic-content" style="color: #1890ff; font-size: 24px; margin-bottom: 8px; font-weight: 700; text-shadow: 0 2px 4px rgba(24, 144, 255, 0.1);">
                            ${{ $ufInfo['value'] }}
                        </div>
                        <div class="ant-statistic-title" style="font-size: 13px; color: rgba(0, 0, 0, 0.65);">
                            <i class="fas fa-calendar" style="margin-right: 6px; color: #1890ff;"></i>
                            {{ \Carbon\Carbon::parse($ufInfo['date'])->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
                <div>
                    <div style="display: flex; flex-direction: column; gap: 8px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); border: 1px solid #e6f7ff; border-radius: 12px; padding: 16px;">
                        <small style="color: rgba(0, 0, 0, 0.65); font-weight: 500;">
                            <i class="fas fa-clock" style="margin-right: 6px; color: #1890ff;"></i>
                            Actualizado: {{ $ufInfo['last_update'] }}
                        </small>
                        <small style="color: rgba(0, 0, 0, 0.65); font-weight: 500;">
                            <i class="fas fa-server" style="margin-right: 6px; color: #52c41a;"></i>
                            Fuente: {{ $ufInfo['source'] }}
                        </small>
                    </div>
                </div>
            </div>
        @else
            <div style="padding: 20px; text-align: center;">
                <div style="color: #ff4d4f; font-size: 16px; margin-bottom: 10px;">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i>
                    No se pudo obtener el valor de la UF
                </div>
                <small style="color: rgba(0, 0, 0, 0.65);">
                    {{ $ufInfo['message'] ?? 'Error desconocido' }}
                </small>
            </div>
        @endif
        
        @if(isset($showRefresh) && $showRefresh)
            <div>
                <button type="button" 
                        class="ant-btn ant-btn-primary" 
                        onclick="location.reload()"
                        title="Actualizar valor de UF"
                        style="background: linear-gradient(135deg, #1890ff 0%, #096dd9 100%); border: none; padding: 8px 20px; border-radius: 8px; font-weight: 500; transition: all 0.3s ease;">
                    <i class="fas fa-sync-alt" style="margin-right: 6px;"></i>
                    Actualizar
                </button>
            </div>
        @endif
    </div>
</div> 