@extends('layouts.app')

@section('title', 'Lista de Proyectos')

@section('content')
<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 24px;">
    <div>
        @include('components.uf-display', ['showRefresh' => true])
    </div>
    <div class="ant-card">
        <div class="ant-card-body" style="text-align: center;">
            <h5 style="margin-bottom: 16px; color: rgba(0, 0, 0, 0.85);">
                <i class="fas fa-chart-bar" style="margin-right: 8px;"></i>
                Resumen de Proyectos
            </h5>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
                <div class="ant-statistic">
                    <div class="ant-statistic-title">Total Proyectos</div>
                    <div class="ant-statistic-content" style="color: var(--ant-primary-color);">
                        {{ $proyectos->count() }}
                    </div>
                </div>
                <div class="ant-statistic">
                    <div class="ant-statistic-title">Completados</div>
                    <div class="ant-statistic-content" style="color: var(--ant-success-color);">
                        {{ $proyectos->where('estado', 'Completado')->count() }}
                    </div>
                </div>
                <div class="ant-statistic">
                    <div class="ant-statistic-title">En Progreso</div>
                    <div class="ant-statistic-content" style="color: var(--ant-warning-color);">
                        {{ $proyectos->where('estado', 'En Progreso')->count() }}
                    </div>
                </div>
                <div class="ant-statistic">
                    <div class="ant-statistic-title">Total Invertido</div>
                    <div class="ant-statistic-content" style="color: #722ed1;">
                        ${{ number_format($proyectos->sum('monto'), 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
        <div class="ant-card">
            <div class="ant-card-head">
                <div class="ant-card-head-wrapper">
                    <div class="ant-card-head-title" style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                        <span>
                            <i class="fas fa-list" style="margin-right: 8px;"></i>
                            Lista de Proyectos
                        </span>

                    </div>
                </div>
            </div>
            <div class="ant-card-body">
                <!-- Mensaje informativo sobre datos de ejemplo -->
                <div style="background: linear-gradient(135deg, #e6f7ff 0%, #bae7ff 100%); border: 1px solid #91d5ff; border-radius: 12px; padding: 16px; margin-bottom: 24px; animation: slideInLeft 0.5s ease;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <i class="fas fa-info-circle" style="color: #1890ff; font-size: 20px; animation: pulse 2s infinite;"></i>
                        <div>
                            <h4 style="margin: 0 0 4px 0; color: #1890ff; font-weight: 600; font-size: 16px;">
                                Datos de Ejemplo
                            </h4>
                            <p style="margin: 0; color: rgba(0, 0, 0, 0.65); font-size: 14px; line-height: 1.5;">
                                Los proyectos mostrados a continuación son datos de ejemplo para demostrar la funcionalidad del sistema. 
                                Puedes crear, editar y eliminar proyectos según tus necesidades.
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($proyectos->count() > 0)
                    <div class="ant-table-wrapper" style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);">
                        <div class="ant-table">
                            <div class="ant-table-container">
                                <div class="ant-table-content">
                                    <table style="width: 100%; border-collapse: collapse;">
                                        <thead class="ant-table-thead">
                                            <tr>
                                                <th class="ant-table-cell" style="background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%); padding: 20px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e8e8e8; color: rgba(0, 0, 0, 0.85);">ID</th>
                                                <th class="ant-table-cell" style="background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%); padding: 20px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e8e8e8; color: rgba(0, 0, 0, 0.85);">Nombre</th>
                                                <th class="ant-table-cell" style="background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%); padding: 20px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e8e8e8; color: rgba(0, 0, 0, 0.85);">Fecha de Inicio</th>
                                                <th class="ant-table-cell" style="background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%); padding: 20px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e8e8e8; color: rgba(0, 0, 0, 0.85);">Estado</th>
                                                <th class="ant-table-cell" style="background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%); padding: 20px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e8e8e8; color: rgba(0, 0, 0, 0.85);">Responsable</th>
                                                <th class="ant-table-cell" style="background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%); padding: 20px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e8e8e8; color: rgba(0, 0, 0, 0.85);">Monto</th>
                                                <th class="ant-table-cell" style="background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%); padding: 20px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e8e8e8; color: rgba(0, 0, 0, 0.85);">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="ant-table-tbody">
                                            @foreach($proyectos as $index => $proyecto)
                                                <tr class="ant-table-row" style="transition: all 0.3s ease; animation: fadeInUp 0.5s ease {{ $index * 0.1 }}s both;">
                                                    <td class="ant-table-cell" style="padding: 20px 16px; border-bottom: 1px solid #f0f0f0; background: white;">{{ $proyecto->id }}</td>
                                                    <td class="ant-table-cell" style="padding: 20px 16px; border-bottom: 1px solid #f0f0f0; background: white;">
                                                        <strong style="color: rgba(0, 0, 0, 0.85);">{{ $proyecto->nombre }}</strong>
                                                    </td>
                                                    <td class="ant-table-cell" style="padding: 20px 16px; border-bottom: 1px solid #f0f0f0; background: white; color: rgba(0, 0, 0, 0.65);">{{ $proyecto->fecha_inicio->format('d/m/Y') }}</td>
                                                    <td class="ant-table-cell" style="padding: 20px 16px; border-bottom: 1px solid #f0f0f0; background: white;">
                                                        @php
                                                            $estadoClass = match($proyecto->estado) {
                                                                'En Progreso' => 'ant-badge ant-badge-status ant-badge-status-processing',
                                                                'Completado' => 'ant-badge ant-badge-status ant-badge-status-success',
                                                                'Pendiente' => 'ant-badge ant-badge-status ant-badge-status-default',
                                                                'Cancelado' => 'ant-badge ant-badge-status ant-badge-status-error',
                                                                default => 'ant-badge ant-badge-status ant-badge-status-warning'
                                                            };
                                                        @endphp
                                                        <span class="{{ $estadoClass }}" style="padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                                            <span class="ant-badge-status-dot" style="margin-right: 6px;"></span>
                                                            {{ $proyecto->estado }}
                                                        </span>
                                                    </td>
                                                    <td class="ant-table-cell" style="padding: 20px 16px; border-bottom: 1px solid #f0f0f0; background: white; color: rgba(0, 0, 0, 0.65);">{{ $proyecto->responsable }}</td>
                                                    <td class="ant-table-cell" style="padding: 20px 16px; border-bottom: 1px solid #f0f0f0; background: white; font-weight: 600; color: var(--ant-success-color); font-size: 15px;">
                                                        ${{ number_format($proyecto->monto, 0, ',', '.') }}
                                                    </td>
                                                    <td class="ant-table-cell" style="padding: 20px 16px; border-bottom: 1px solid #f0f0f0; background: white;">
                                                        <div style="display: flex; gap: 8px;">
                                                            <a href="{{ route('proyectos.show', $proyecto->id) }}" 
                                                               class="ant-btn ant-btn-text" 
                                                               title="Ver detalles"
                                                               style="padding: 8px 12px; min-width: auto; border-radius: 8px; transition: all 0.3s ease;">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ route('proyectos.edit', $proyecto->id) }}" 
                                                               class="ant-btn ant-btn-text" 
                                                               title="Editar"
                                                               style="padding: 8px 12px; min-width: auto; border-radius: 8px; transition: all 0.3s ease;">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('proyectos.destroy', $proyecto->id) }}" 
                                                                  method="POST" 
                                                                  style="display: inline;"
                                                                  onsubmit="return confirm('¿Estás seguro de que quieres eliminar este proyecto?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" 
                                                                        class="ant-btn ant-btn-text ant-btn-dangerous" 
                                                                        title="Eliminar"
                                                                        style="padding: 8px 12px; min-width: auto; border-radius: 8px; transition: all 0.3s ease;">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div style="text-align: center; padding: 48px 0;">
                        <i class="fas fa-folder-open" style="font-size: 48px; color: rgba(0, 0, 0, 0.25); margin-bottom: 16px;"></i>
                        <h5 style="color: rgba(0, 0, 0, 0.45); margin-bottom: 8px;">No hay proyectos registrados</h5>
                        <p style="color: rgba(0, 0, 0, 0.45); margin-bottom: 16px;">Comienza creando tu primer proyecto</p>
                        <a href="{{ route('proyectos.create') }}" class="ant-btn ant-btn-primary">
                            <i class="fas fa-plus"></i>
                            Crear Proyecto
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 