<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Proyecto;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = [
            [
                'nombre' => 'istema Web E-commerce',
                'fecha_inicio' => '2024-01-15',
                'estado' => 'En Progreso',
                'responsable' => 'María González',
                'monto' => 25000000
            ],
            [
                'nombre' => 'Migración de Base de Datos Legacy',
                'fecha_inicio' => '2024-02-01',
                'estado' => 'Completado',
                'responsable' => 'Carlos Rodríguez',
                'monto' => 15000000
            ],
            [
                'nombre' => 'Implementación de API REST',
                'fecha_inicio' => '2024-03-10',
                'estado' => 'Pendiente',
                'responsable' => 'Ana Martínez',
                'monto' => 8000000
            ],
            [
                'nombre' => 'Desarrollo de Aplicación Móvil',
                'fecha_inicio' => '2024-01-20',
                'estado' => 'En Progreso',
                'responsable' => 'Luis Pérez',
                'monto' => 35000000
            ],
            [
                'nombre' => 'Auditoría de Seguridad IT',
                'fecha_inicio' => '2024-02-15',
                'estado' => 'Cancelado',
                'responsable' => 'Patricia Silva',
                'monto' => 12000000
            ]
        ];

        foreach ($proyectos as $proyecto) {
            Proyecto::create($proyecto);
        }
    }
}
