@extends('layouts.app')

@section('title', 'Detalles del Proyecto')

@section('content')
<div style="display: flex; justify-content: center; padding: 20px;">
    <div style="width: 100%; max-width: 900px;">
        <!-- Header con información -->
        <div style="margin-bottom: 24px; animation: slideInLeft 0.6s ease;">
            <div style="background: linear-gradient(135deg, #52c41a 0%, #389e0d 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 32px rgba(82, 196, 26, 0.3);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="background: rgba(255, 255, 255, 0.2); border-radius: 12px; padding: 12px; backdrop-filter: blur(10px);">
                        <i class="fas fa-eye" style="font-size: 24px; color: white;"></i>
                    </div>
                    <div>
                        <h1 style="margin: 0 0 8px 0; font-size: 28px; font-weight: 700; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            Detalles del Proyecto
                        </h1>
                        <p style="margin: 0; opacity: 0.9; font-size: 16px; line-height: 1.5;">
                            Información completa del proyecto: <strong>{{ $proyecto->nombre }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información principal -->
        <div class="ant-card" style="animation: fadeInUp 0.8s ease;">
            <div class="ant-card-head" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #e9ecef;">
                <div class="ant-card-head-wrapper">
                    <div class="ant-card-head-title" style="font-size: 18px; font-weight: 600; color: #495057;">
                        <i class="fas fa-info-circle" style="margin-right: 12px; color: #52c41a;"></i>
                        Información del Proyecto
                    </div>
                </div>
            </div>
            <div class="ant-card-body" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <!-- Primera fila: ID y Nombre -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div class="ant-descriptions-item" style="animation: slideInLeft 0.6s ease 0.3s both;">
                        <div style="background: linear-gradient(135deg, #f0f8ff 0%, #e6f7ff 100%); border: 1px solid #bae7ff; border-radius: 12px; padding: 20px;">
                            <label style="font-weight: 600; color: #1890ff; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-hashtag" style="margin-right: 8px;"></i>
                                ID del Proyecto
                            </label>
                            <p style="margin: 0; color: #1890ff; font-size: 18px; font-weight: 700;">#{{ $proyecto->id }}</p>
                        </div>
                    </div>

                    <div class="ant-descriptions-item" style="animation: slideInRight 0.6s ease 0.4s both;">
                        <div style="background: linear-gradient(135deg, #f6ffed 0%, #d9f7be 100%); border: 1px solid #b7eb8f; border-radius: 12px; padding: 20px;">
                            <label style="font-weight: 600; color: #52c41a; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-tag" style="margin-right: 8px;"></i>
                                Nombre del Proyecto
                            </label>
                            <p style="margin: 0; color: #52c41a; font-size: 16px; font-weight: 600;">{{ $proyecto->nombre }}</p>
                        </div>
                    </div>
                </div>

                <!-- Segunda fila: Fecha y Estado -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div class="ant-descriptions-item" style="animation: slideInLeft 0.6s ease 0.5s both;">
                        <div style="background: linear-gradient(135deg, #fff7e6 0%, #ffe7ba 100%); border: 1px solid #ffd591; border-radius: 12px; padding: 20px;">
                            <label style="font-weight: 600; color: #fa8c16; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-calendar-alt" style="margin-right: 8px;"></i>
                                Fecha de Inicio
                            </label>
                            <p style="margin: 0; color: #fa8c16; font-size: 16px; font-weight: 600;">{{ $proyecto->fecha_inicio->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="ant-descriptions-item" style="animation: slideInRight 0.6s ease 0.6s both;">
                        <div style="background: linear-gradient(135deg, #f9f0ff 0%, #efdbff 100%); border: 1px solid #d3adf7; border-radius: 12px; padding: 20px;">
                            <label style="font-weight: 600; color: #722ed1; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-tasks" style="margin-right: 8px;"></i>
                                Estado del Proyecto
                            </label>
                            <div style="margin: 0;">
                                @php
                                    $estadoClass = match($proyecto->estado) {
                                        'En Progreso' => 'ant-badge ant-badge-status ant-badge-status-processing',
                                        'Completado' => 'ant-badge ant-badge-status ant-badge-status-success',
                                        'Pendiente' => 'ant-badge ant-badge-status ant-badge-status-default',
                                        'Cancelado' => 'ant-badge ant-badge-status ant-badge-status-error',
                                        default => 'ant-badge ant-badge-status ant-badge-status-warning'
                                    };
                                @endphp
                                <span class="{{ $estadoClass }}" style="padding: 6px 12px; border-radius: 20px; font-size: 14px; font-weight: 600;">
                                    <span class="ant-badge-status-dot" style="margin-right: 8px;"></span>
                                    {{ $proyecto->estado }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tercera fila: Responsable y Monto -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                    <div class="ant-descriptions-item" style="animation: slideInLeft 0.6s ease 0.7s both;">
                        <div style="background: linear-gradient(135deg, #fff1f0 0%, #ffccc7 100%); border: 1px solid #ffa39e; border-radius: 12px; padding: 20px;">
                            <label style="font-weight: 600; color: #f5222d; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-user-tie" style="margin-right: 8px;"></i>
                                Responsable del Proyecto
                            </label>
                            <p style="margin: 0; color: #f5222d; font-size: 16px; font-weight: 600;">{{ $proyecto->responsable }}</p>
                        </div>
                    </div>

                    <div class="ant-descriptions-item" style="animation: slideInRight 0.6s ease 0.8s both;">
                        <div style="background: linear-gradient(135deg, #f6ffed 0%, #b7eb8f 100%); border: 1px solid #95de64; border-radius: 12px; padding: 20px;">
                            <label style="font-weight: 600; color: #52c41a; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-dollar-sign" style="margin-right: 8px;"></i>
                                Presupuesto del Proyecto
                            </label>
                            <p style="margin: 0; color: #52c41a; font-size: 20px; font-weight: 700; text-shadow: 0 2px 4px rgba(82, 196, 26, 0.1);">
                                ${{ number_format($proyecto->monto, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Cuarta fila: Fechas de sistema -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                    <div class="ant-descriptions-item" style="animation: slideInLeft 0.6s ease 0.9s both;">
                        <div style="background: linear-gradient(135deg, #f0f5ff 0%, #d6e4ff 100%); border: 1px solid #adc6ff; border-radius: 12px; padding: 20px;">
                            <label style="font-weight: 600; color: #1890ff; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-clock" style="margin-right: 8px;"></i>
                                Fecha de Creación
                            </label>
                            <p style="margin: 0; color: #1890ff; font-size: 14px; font-weight: 500;">{{ $proyecto->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="ant-descriptions-item" style="animation: slideInRight 0.6s ease 1s both;">
                        <div style="background: linear-gradient(135deg, #fff2e8 0%, #ffbb96 100%); border: 1px solid #ff9c6e; border-radius: 12px; padding: 20px;">
                            <label style="font-weight: 600; color: #fa541c; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-edit" style="margin-right: 8px;"></i>
                                Última Actualización
                            </label>
                            <p style="margin: 0; color: #fa541c; font-size: 14px; font-weight: 500;">{{ $proyecto->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 24px; border-top: 2px solid #e9ecef; animation: fadeInUp 0.6s ease 1.1s both;">
                    <a href="{{ route('proyectos.index') }}" 
                       class="ant-btn" 
                       style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-arrow-left"></i>
                        Volver a Proyectos
                    </a>
                    <div style="display: flex; gap: 12px;">
                        <a href="{{ route('proyectos.edit', $proyecto->id) }}" 
                           class="ant-btn ant-btn-primary"
                           style="background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 100%); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 154, 86, 0.3);">
                            <i class="fas fa-edit"></i>
                            Editar Proyecto
                        </a>
                        <form action="{{ route('proyectos.destroy', $proyecto->id) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('¿Estás seguro de que quieres eliminar este proyecto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="ant-btn ant-btn-dangerous"
                                    style="background: linear-gradient(135deg, #ff4d4f 0%, #cf1322 100%); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 77, 79, 0.3);">
                                <i class="fas fa-trash"></i>
                                Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Efectos hover para botones */
.ant-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2) !important;
}

/* Efectos hover para las cards de información */
.ant-descriptions-item > div:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}
</style>
@endsection 