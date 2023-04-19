<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Municipality;

class MunicipalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $municipalities = [
            //Pinar del Río
            ['name' => 'Consolación del Sur', 'province_id' => 1],
            ['name' => 'Guane', 'province_id' => 1],
            ['name' => 'La Palma', 'province_id' => 1],
            ['name' => 'Los Palacios', 'province_id' => 1],
            ['name' => 'Mantua', 'province_id' => 1],
            ['name' => 'Minas de Matahambre', 'province_id' => 1],
            ['name' => 'Pinar del Río', 'province_id' => 1],
            ['name' => 'San Juan y Martínes', 'province_id' => 1],
            ['name' => 'San Luis', 'province_id' => 1],
            ['name' => 'Sandino', 'province_id' => 1],
            ['name' => 'Viñales', 'province_id' => 1],

            //Artemisa
            ['name' => 'Alquízar', 'province_id' => 2],
            ['name' => 'Artemisa', 'province_id' => 2],
            ['name' => 'Bahía Honda', 'province_id' => 2],
            ['name' => 'Bauta', 'province_id' => 2],
            ['name' => 'Caimito', 'province_id' => 2],
            ['name' => 'Candelaria', 'province_id' => 2],
            ['name' => 'Guanajay', 'province_id' => 2],
            ['name' => 'Guira de Melena', 'province_id' => 2],
            ['name' => 'Mariel', 'province_id' => 2],
            ['name' => 'San Antonio de los Baños', 'province_id' => 2],
            ['name' => 'San Cristóbal', 'province_id' => 2],

            //La Habana
            ['name' => 'Arroyo Naranjo', 'province_id' => 3],
            ['name' => 'Boyeros', 'province_id' => 3],
            ['name' => 'Centro Habana', 'province_id' => 3],
            ['name' => 'Cerro', 'province_id' => 3],
            ['name' => 'Cotorro', 'province_id' => 3],
            ['name' => 'Diez de Octubre', 'province_id' => 3],
            ['name' => 'Guanabacoa', 'province_id' => 3],
            ['name' => 'La Habana del Este', 'province_id' => 3],
            ['name' => 'La Habana Vieja', 'province_id' => 3],
            ['name' => 'La Isla', 'province_id' => 3],
            ['name' => 'Marianao', 'province_id' => 3],
            ['name' => 'Playa', 'province_id' => 3],
            ['name' => 'Plaza de la Revolución', 'province_id' => 3],
            ['name' => 'Regla', 'province_id' => 3],
            ['name' => 'San Miguel del Padrón', 'province_id' => 3],

            //Mayabeque
            ['name' => 'Batabanó', 'province_id' => 4],
            ['name' => 'Bejucal', 'province_id' => 4],
            ['name' => 'Guines', 'province_id' => 4],
            ['name' => 'Jaruco', 'province_id' => 4],
            ['name' => 'Madruga', 'province_id' => 4],
            ['name' => 'Melena del Sur', 'province_id' => 4],
            ['name' => 'Nueva Paz', 'province_id' => 4],
            ['name' => 'Quivicán', 'province_id' => 4],
            ['name' => 'San José de las Lajas', 'province_id' => 4],
            ['name' => 'San Nicolás', 'province_id' => 4],
            ['name' => 'Santa Cruz del Norte', 'province_id' => 4],

            //Matanzas
            ['name' => 'Calimete', 'province_id' => 5],
            ['name' => 'Cárdenas', 'province_id' => 5],
            ['name' => 'Ciénaga de Zapata', 'province_id' => 5],
            ['name' => 'Colón', 'province_id' => 5],
            ['name' => 'Jaguey Grande', 'province_id' => 5],
            ['name' => 'Jovellanos', 'province_id' => 5],
            ['name' => 'Limonar', 'province_id' => 5],
            ['name' => 'Los Arabos', 'province_id' => 5],
            ['name' => 'Martí', 'province_id' => 5],
            ['name' => 'Matanzas', 'province_id' => 5],
            ['name' => 'Pedro Betancourt', 'province_id' => 5],
            ['name' => 'Unión de Reyes', 'province_id' => 5],

            //Cienfuegos
            ['name' => 'Abreus', 'province_id' => 6],
            ['name' => 'Aguada de Pasajeros', 'province_id' => 6],
            ['name' => 'Cienfuegos', 'province_id' => 6],
            ['name' => 'Cruces', 'province_id' => 6],
            ['name' => 'Cumanayagua', 'province_id' => 6],
            ['name' => 'Lajas', 'province_id' => 6],
            ['name' => 'Palmira', 'province_id' => 6],
            ['name' => 'Rodas', 'province_id' => 6],

            //Villa Clara
            ['name' => 'Caibarién', 'province_id' => 7],
            ['name' => 'Camajuaní', 'province_id' => 7],
            ['name' => 'Cifuentes', 'province_id' => 7],
            ['name' => 'Corralillo', 'province_id' => 7],
            ['name' => 'Encrucijada', 'province_id' => 7],
            ['name' => 'Manicaragua', 'province_id' => 7],
            ['name' => 'Placetas', 'province_id' => 7],
            ['name' => 'Quemado de Guines', 'province_id' => 7],
            ['name' => 'Ranchuelo', 'province_id' => 7],
            ['name' => 'San Juan de los Remedios', 'province_id' => 7],
            ['name' => 'Sagua la Grande', 'province_id' => 7],
            ['name' => 'Santa Clara', 'province_id' => 7],
            ['name' => 'Santo Domingo', 'province_id' => 7],

            //Santi Spíritus
            ['name' => 'Cabaiguán', 'province_id' => 8],
            ['name' => 'Fomento', 'province_id' => 8],
            ['name' => 'Jatibonico', 'province_id' => 8],
            ['name' => 'La Sierpe', 'province_id' => 8],
            ['name' => 'Sancti Spíritus', 'province_id' => 8],
            ['name' => 'Taguasco', 'province_id' => 8],
            ['name' => 'Trinidad', 'province_id' => 8],
            ['name' => 'Yaguajay', 'province_id' => 8],

            //Ciego de Ávila
            ['name' => 'Baraguá', 'province_id' => 9],
            ['name' => 'Bolivia', 'province_id' => 9],
            ['name' => 'Chambas', 'province_id' => 9],
            ['name' => 'Ciego de Ávila', 'province_id' => 9],
            ['name' => 'Ciro Redondo', 'province_id' => 9],
            ['name' => 'Florencia', 'province_id' => 9],
            ['name' => 'Majagua', 'province_id' => 9],
            ['name' => 'Morón', 'province_id' => 9],
            ['name' => 'Primero de Enero', 'province_id' => 9],
            ['name' => 'Venezuela', 'province_id' => 9],

            //Camaguey
            ['name' => 'Camaguey', 'province_id' => 10],
            ['name' => 'Carlos Manuel de Céspedes', 'province_id' => 10],
            ['name' => 'Esmeralda', 'province_id' => 10],
            ['name' => 'Florida', 'province_id' => 10],
            ['name' => 'Guáimaro', 'province_id' => 10],
            ['name' => 'Jimaguayú', 'province_id' => 10],
            ['name' => 'Minas', 'province_id' => 10],
            ['name' => 'Najasa', 'province_id' => 10],
            ['name' => 'Nuevitas', 'province_id' => 10],
            ['name' => 'Santa Cruz', 'province_id' => 10],
            ['name' => 'Sibanicú', 'province_id' => 10],
            ['name' => 'Sierra de Cubitas', 'province_id' => 10],
            ['name' => 'Vertientes', 'province_id' => 10],

            //Las Tunas
            ['name' => 'Amancio', 'province_id' => 11],
            ['name' => 'Colombia', 'province_id' => 11],
            ['name' => 'Jesús Menéndez', 'province_id' => 11],
            ['name' => 'Jobabo', 'province_id' => 11],
            ['name' => 'Las Tunas', 'province_id' => 11],
            ['name' => 'Majibacoa', 'province_id' => 11],
            ['name' => 'Manatí', 'province_id' => 11],
            ['name' => 'Puerto Padre', 'province_id' => 11],

            //Holguín
            ['name' => 'Antilla', 'province_id' => 12],
            ['name' => 'Báguanos', 'province_id' => 12],
            ['name' => 'Banes', 'province_id' => 12],
            ['name' => 'Cacocum', 'province_id' => 12],
            ['name' => 'Calixto García', 'province_id' => 12],
            ['name' => 'Cueto', 'province_id' => 12],
            ['name' => 'Frank País', 'province_id' => 12],
            ['name' => 'Gibara', 'province_id' => 12],
            ['name' => 'Holguín', 'province_id' => 12],
            ['name' => 'Mayarí', 'province_id' => 12],
            ['name' => 'Moa', 'province_id' => 12],
            ['name' => 'Rafael Freyre', 'province_id' => 12],
            ['name' => 'Sagua de Tánamo', 'province_id' => 12],
            ['name' => 'Urbano Noris', 'province_id' => 12],

            //Granma
            ['name' => 'Bartolomé  Masó', 'province_id' => 13],
            ['name' => 'Bayamo', 'province_id' => 13],
            ['name' => 'Buey Arriba', 'province_id' => 13],
            ['name' => 'Campechuela', 'province_id' => 13],
            ['name' => 'Cauto Cristo', 'province_id' => 13],
            ['name' => 'Guisa', 'province_id' => 13],
            ['name' => 'Jiguaní', 'province_id' => 13],
            ['name' => 'Manzanillo', 'province_id' => 13],
            ['name' => 'Media Luna', 'province_id' => 13],
            ['name' => 'Niquero', 'province_id' => 13],
            ['name' => 'Pilón', 'province_id' => 13],
            ['name' => 'Río Cauto', 'province_id' => 13],
            ['name' => 'Yara', 'province_id' => 13],

            //Santiago de Cuba
            ['name' => 'Contramaestre', 'province_id' => 14],
            ['name' => 'Guamá', 'province_id' => 14],
            ['name' => 'Mella', 'province_id' => 14],
            ['name' => 'Palma Soriano', 'province_id' => 14],
            ['name' => 'San Luis', 'province_id' => 14],
            ['name' => 'Santiago de Cuba', 'province_id' => 14],
            ['name' => 'Segundo Frente', 'province_id' => 14],
            ['name' => 'Songo La Maya', 'province_id' => 14],
            ['name' => 'Tercer Frente', 'province_id' => 14],

            //Guantánamo
            ['name' => 'Baracoa', 'province_id' => 15],
            ['name' => 'Caimanera', 'province_id' => 15],
            ['name' => 'El Salvador', 'province_id' => 15],
            ['name' => 'Guantánamo', 'province_id' => 15],
            ['name' => 'Imías', 'province_id' => 15],
            ['name' => 'Maisí', 'province_id' => 15],
            ['name' => 'Manuel Tames', 'province_id' => 15],
            ['name' => 'Niceto Pérez', 'province_id' => 15],
            ['name' => 'San Antonio del Sur', 'province_id' => 15],
            ['name' => 'Yateras', 'province_id' => 15],
        ];

        $this->create($municipalities);
    }

    public function create($municipalities)
    {
        foreach($municipalities as $municipality)
        {
            Municipality::create(['name' => $municipality['name'], 'province_id' => $municipality['province_id']]);
        }
    }
}
