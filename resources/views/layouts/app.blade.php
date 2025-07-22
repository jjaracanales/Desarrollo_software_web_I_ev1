<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Gestión de Proyectos') - Tech Solutions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/antd@5.12.8/dist/reset.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/antd@5.12.8/dist/antd.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --ant-primary-color: #1890ff;
            --ant-success-color: #52c41a;
            --ant-warning-color: #faad14;
            --ant-error-color: #ff4d4f;
        }
        
        body {
            background-color: #f0f2f5;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        
        .ant-layout {
            min-height: 100vh;
        }
        
        .ant-layout-header {
            background: #001529;
            padding: 0;
            height: 80px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo-container img {
            border-radius: 6px;
            transition: transform 0.3s ease;
        }
        
        .logo-container img:hover {
            transform: scale(1.05);
        }
        
        .ant-btn-ghost {
            background: transparent;
            border: 1px solid;
            color: rgba(255, 255, 255, 0.85);
            transition: all 0.3s;
            font-weight: 500;
            font-size: 14px;
        }
        
        .ant-btn-ghost:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: white;
            transform: translateY(-1px);
        }
        
        .ant-btn-primary {
            background: #1890ff;
            border-color: #1890ff;
            color: white;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 14px;
        }
        
        .ant-btn-primary:hover {
            background: #40a9ff;
            border-color: #40a9ff;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(24, 144, 255, 0.4);
        }
        
        .ant-layout-content {
            padding: 24px;
            background: #f0f2f5;
        }
        
        .logo {
            color: white;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
        }
        
        .ant-menu-dark {
            background: transparent;
        }
        
        .ant-card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05), 0 2px 4px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }
        
        .ant-card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1), 0 4px 10px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
        
        .ant-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #1890ff, #722ed1, #eb2f96);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .ant-card:hover::before {
            opacity: 1;
        }
        
        .ant-card-head {
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            padding: 0 24px;
            background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
            position: relative;
        }
        
        .ant-card-head-title {
            font-weight: 600;
            color: rgba(0, 0, 0, 0.85);
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        
        .ant-card-body {
            padding: 24px;
            background: white;
        }
        
        .ant-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .ant-table-thead > tr > th {
            background: #fafafa;
            font-weight: 600;
        }
        
        .ant-table-tbody > tr:hover > td {
            background-color: #f5f5f5;
        }
        
        .ant-table-tbody > tr > td {
            transition: background-color 0.3s;
        }
        
        .ant-badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        
        .ant-badge-status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }
        
        .ant-badge-status-processing .ant-badge-status-dot {
            background-color: #1890ff;
        }
        
        .ant-badge-status-success .ant-badge-status-dot {
            background-color: #52c41a;
        }
        
        .ant-badge-status-default .ant-badge-status-dot {
            background-color: #d9d9d9;
        }
        
        .ant-badge-status-error .ant-badge-status-dot {
            background-color: #ff4d4f;
        }
        
        .ant-badge-status-warning .ant-badge-status-dot {
            background-color: #faad14;
        }
        
        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        /* Efectos de hover mejorados para la tabla */
        .ant-table-tbody > tr:hover > td {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .ant-table-tbody > tr > td {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Mejoras en los botones de acción */
        .ant-btn-text:hover {
            background: linear-gradient(135deg, #f0f0f0 0%, #e6e6e6 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        .ant-btn-dangerous:hover {
            background: linear-gradient(135deg, #fff2f0 0%, #ffccc7 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 77, 79, 0.3);
        }
        
        .ant-btn {
            border-radius: 6px;
            height: 32px;
            padding: 4px 15px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.3s;
        }
        
        .ant-btn-text {
            border: none;
            background: transparent;
            color: rgba(0, 0, 0, 0.45);
        }
        
        .ant-btn-text:hover {
            background-color: rgba(0, 0, 0, 0.04);
            color: rgba(0, 0, 0, 0.85);
        }
        
        .ant-btn-dangerous {
            color: #ff4d4f;
        }
        
        .ant-btn-dangerous:hover {
            background-color: #fff2f0;
            color: #ff4d4f;
        }
        
        .ant-btn-primary {
            background: var(--ant-primary-color);
            border-color: var(--ant-primary-color);
        }
        
        .ant-btn-success {
            background: var(--ant-success-color);
            border-color: var(--ant-success-color);
            color: white;
        }
        
        .ant-btn-warning {
            background: var(--ant-warning-color);
            border-color: var(--ant-warning-color);
            color: white;
        }
        
        .ant-btn-danger {
            background: var(--ant-error-color);
            border-color: var(--ant-error-color);
            color: white;
        }
        
        .ant-form-item-label > label {
            font-weight: 500;
        }
        
        .ant-input, .ant-select-selector, .ant-picker {
            border-radius: 6px;
        }
        
        .ant-alert {
            border-radius: 6px;
            margin-bottom: 16px;
        }
        
        .ant-badge {
            font-size: 12px;
        }
        
        .ant-statistic {
            text-align: center;
            padding: 16px;
            border-radius: 8px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .ant-statistic:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .ant-statistic::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s;
        }
        
        .ant-statistic:hover::before {
            left: 100%;
        }
        
        .ant-statistic-title {
            font-size: 14px;
            color: rgba(0, 0, 0, 0.65);
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .ant-statistic-content {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(45deg, #1890ff, #722ed1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body>
    <div class="ant-layout">
        <header class="ant-layout-header">
            <div style="display: flex; justify-content: space-between; align-items: center; height: 100%; padding: 0 32px;">
                <div class="logo-container">
                    <a href="{{ route('proyectos.index') }}" style="color: white; text-decoration: none; display: flex; align-items: center;">
                        <span style="font-size: 24px; font-weight: 700; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                            <i class="fas fa-project-diagram" style="margin-right: 8px; color: #1890ff;"></i>
                            Proyectos Tech Solutions
                        </span>
                    </a>
                </div>
                <div style="display: flex; gap: 20px;">
                    <a href="{{ route('proyectos.index') }}" class="ant-btn ant-btn-ghost" style="color: white; border-color: rgba(255, 255, 255, 0.3); height: 40px; padding: 0 20px;">
                        <i class="fas fa-list" style="margin-right: 6px;"></i>
                        Proyectos
                    </a>
                    <a href="{{ route('proyectos.create') }}" class="ant-btn ant-btn-primary" style="background: #1890ff; border-color: #1890ff; height: 40px; padding: 0 20px;">
                        <i class="fas fa-plus" style="margin-right: 6px;"></i>
                        Nuevo Proyecto
                    </a>
                </div>
            </div>
        </header>

        <main class="ant-layout-content">
            @if(session('success'))
                <div class="ant-alert ant-alert-success" role="alert">
                    <span class="ant-alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </span>
                    <div class="ant-alert-content">
                        <div class="ant-alert-message">{{ session('success') }}</div>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="ant-alert ant-alert-error" role="alert">
                    <span class="ant-alert-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </span>
                    <div class="ant-alert-content">
                        <div class="ant-alert-message">
                            <ul style="margin: 0; padding-left: 16px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </main>

        <footer style="text-align: center; padding: 24px; background: white; border-top: 1px solid #f0f0f0;">
            <p style="margin: 0; color: rgba(0, 0, 0, 0.45);">
                <i class="fas fa-code" style="margin-right: 4px;"></i>
                Sistema de Gestión de Proyectos - Tech Solutions - Trabajo por José Jara Canales
            </p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/antd@5.12.8/dist/antd.min.js"></script>
    @yield('scripts')
</body>
</html> 