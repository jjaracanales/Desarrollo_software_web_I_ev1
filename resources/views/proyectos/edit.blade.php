@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('content')
<div style="display: flex; justify-content: center; padding: 20px;">
    <div style="width: 100%; max-width: 900px;">
        <!-- Header con información -->
        <div style="margin-bottom: 24px; animation: slideInLeft 0.6s ease;">
            <div style="background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 100%); border-radius: 16px; padding: 24px; color: white; box-shadow: 0 8px 32px rgba(255, 154, 86, 0.3);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="background: rgba(255, 255, 255, 0.2); border-radius: 12px; padding: 12px; backdrop-filter: blur(10px);">
                        <i class="fas fa-edit" style="font-size: 24px; color: white;"></i>
                    </div>
                    <div>
                        <h1 style="margin: 0 0 8px 0; font-size: 28px; font-weight: 700; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                            Editar Proyecto
                        </h1>
                        <p style="margin: 0; opacity: 0.9; font-size: 16px; line-height: 1.5;">
                            Modifica la información del proyecto: <strong>{{ $proyecto->nombre }}</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulario principal -->
        <div class="ant-card" style="animation: fadeInUp 0.8s ease;">
            <div class="ant-card-head" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-bottom: 2px solid #e9ecef;">
                <div class="ant-card-head-wrapper">
                    <div class="ant-card-head-title" style="font-size: 18px; font-weight: 600; color: #495057;">
                        <i class="fas fa-cog" style="margin-right: 12px; color: #ff9a56;"></i>
                        Información del Proyecto
                    </div>
                </div>
            </div>
            <div class="ant-card-body" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <form action="{{ route('proyectos.update', $proyecto->id) }}" method="POST" style="animation: fadeInUp 1s ease 0.2s both;">
                    @csrf
                    @method('PUT')
                    
                    <!-- Primera fila: Nombre y Fecha -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div class="ant-form-item @error('nombre') ant-form-item-has-error @enderror" style="animation: slideInLeft 0.6s ease 0.3s both;">
                            <label class="ant-form-item-label" for="nombre" style="font-weight: 600; color: #495057; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-tag" style="margin-right: 8px; color: #ff9a56;"></i>
                                Nombre del Proyecto *
                            </label>
                            <div class="ant-form-item-control">
                                <input type="text" 
                                       class="ant-input @error('nombre') ant-input-status-error @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre', $proyecto->nombre) }}" 
                                       required 
                                       placeholder="Ej: Sistema de Gestión de Inventarios"
                                       style="border-radius: 12px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 14px; transition: all 0.3s ease; background: white;">
                                @error('nombre')
                                    <div class="ant-form-item-explain-error" style="color: #ff4d4f; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="ant-form-item @error('fecha_inicio') ant-form-item-has-error @enderror" style="animation: slideInRight 0.6s ease 0.4s both;">
                            <label class="ant-form-item-label" for="fecha_inicio" style="font-weight: 600; color: #495057; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-calendar-alt" style="margin-right: 8px; color: #ff9a56;"></i>
                                Fecha de Inicio *
                            </label>
                            <div class="ant-form-item-control">
                                <input type="date" 
                                       class="ant-input @error('fecha_inicio') ant-input-status-error @enderror" 
                                       id="fecha_inicio" 
                                       name="fecha_inicio" 
                                       value="{{ old('fecha_inicio', $proyecto->fecha_inicio->format('Y-m-d')) }}" 
                                       required
                                       style="border-radius: 12px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 14px; transition: all 0.3s ease; background: white;">
                                @error('fecha_inicio')
                                    <div class="ant-form-item-explain-error" style="color: #ff4d4f; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Segunda fila: Estado y Responsable -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                        <div class="ant-form-item @error('estado') ant-form-item-has-error @enderror" style="animation: slideInLeft 0.6s ease 0.5s both;">
                            <label class="ant-form-item-label" for="estado" style="font-weight: 600; color: #495057; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-tasks" style="margin-right: 8px; color: #ff9a56;"></i>
                                Estado del Proyecto *
                            </label>
                            <div class="ant-form-item-control">
                                <select class="ant-select @error('estado') ant-select-status-error @enderror" 
                                        id="estado" 
                                        name="estado" 
                                        required
                                        style="border-radius: 12px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 14px; transition: all 0.3s ease; background: white; width: 100%;">
                                    <option value="">Seleccione el estado</option>
                                    <option value="Pendiente" {{ old('estado', $proyecto->estado) == 'Pendiente' ? 'selected' : '' }}>🟡 Pendiente</option>
                                    <option value="En Progreso" {{ old('estado', $proyecto->estado) == 'En Progreso' ? 'selected' : '' }}>🔵 En Progreso</option>
                                    <option value="Completado" {{ old('estado', $proyecto->estado) == 'Completado' ? 'selected' : '' }}>🟢 Completado</option>
                                    <option value="Cancelado" {{ old('estado', $proyecto->estado) == 'Cancelado' ? 'selected' : '' }}>🔴 Cancelado</option>
                                </select>
                                @error('estado')
                                    <div class="ant-form-item-explain-error" style="color: #ff4d4f; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="ant-form-item @error('responsable') ant-form-item-has-error @enderror" style="animation: slideInRight 0.6s ease 0.6s both;">
                            <label class="ant-form-item-label" for="responsable" style="font-weight: 600; color: #495057; margin-bottom: 8px; display: block; font-size: 14px;">
                                <i class="fas fa-user-tie" style="margin-right: 8px; color: #ff9a56;"></i>
                                Responsable del Proyecto *
                            </label>
                            <div class="ant-form-item-control">
                                <input type="text" 
                                       class="ant-input @error('responsable') ant-input-status-error @enderror" 
                                       id="responsable" 
                                       name="responsable" 
                                       value="{{ old('responsable', $proyecto->responsable) }}" 
                                       required 
                                       placeholder="Ej: Juan Pérez"
                                       style="border-radius: 12px; border: 2px solid #e9ecef; padding: 12px 16px; font-size: 14px; transition: all 0.3s ease; background: white;">
                                @error('responsable')
                                    <div class="ant-form-item-explain-error" style="color: #ff4d4f; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tercera fila: Monto -->
                    <div class="ant-form-item @error('monto') ant-form-item-has-error @enderror" style="margin-bottom: 32px; animation: fadeInUp 0.6s ease 0.7s both;">
                        <label class="ant-form-item-label" for="monto" style="font-weight: 600; color: #495057; margin-bottom: 8px; display: block; font-size: 14px;">
                            <i class="fas fa-dollar-sign" style="margin-right: 8px; color: #ff9a56;"></i>
                            Presupuesto del Proyecto *
                        </label>
                        <div class="ant-form-item-control">
                            <div style="display: flex; align-items: center; background: white; border-radius: 12px; border: 2px solid #e9ecef; overflow: hidden; transition: all 0.3s ease;">
                                <span style="display: flex; align-items: center; padding: 12px 16px; background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 100%); color: white; font-weight: 600; font-size: 16px; min-width: 60px; justify-content: center;">
                                    <i class="fas fa-dollar-sign" style="margin-right: 4px;"></i>
                                </span>
                                <input type="number" 
                                       class="ant-input @error('monto') ant-input-status-error @enderror" 
                                       id="monto" 
                                       name="monto" 
                                       value="{{ old('monto', $proyecto->monto) }}" 
                                       required 
                                       min="0" 
                                       step="1000" 
                                       placeholder="0"
                                       style="border: none; padding: 12px 16px; font-size: 16px; font-weight: 500; background: transparent; flex: 1;">
                            </div>
                            @error('monto')
                                <div class="ant-form-item-explain-error" style="color: #ff4d4f; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 24px; border-top: 2px solid #e9ecef; animation: fadeInUp 0.6s ease 0.8s both;">
                        <a href="{{ route('proyectos.show', $proyecto->id) }}" 
                           class="ant-btn" 
                           style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fas fa-times"></i>
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="ant-btn ant-btn-primary"
                                style="background: linear-gradient(135deg, #ff9a56 0%, #ff6b6b 100%); color: white; border: none; padding: 14px 32px; border-radius: 12px; font-weight: 600; font-size: 16px; transition: all 0.3s ease; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 15px rgba(255, 154, 86, 0.3);">
                            <i class="fas fa-save"></i>
                            Actualizar Proyecto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Efectos hover para inputs */
.ant-input:focus, .ant-select:focus {
    border-color: #ff9a56 !important;
    box-shadow: 0 0 0 3px rgba(255, 154, 86, 0.1) !important;
    outline: none;
}

.ant-input:hover, .ant-select:hover {
    border-color: #ff9a56 !important;
}

/* Efectos hover para botones */
.ant-btn:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(255, 154, 86, 0.4) !important;
}
</style>
@endsection 