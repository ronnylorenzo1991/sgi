<?php

namespace Database\Seeders;

use App\Models\Categories\Entity\Category;
use App\Models\Subcategories\Entity\Subcategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::create([
            'name'        => 'Daños Éticos y sociales',
            'description' => 'Daños Éticos y sociales',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Eco mediático de noticias falsas',
                'description' => 'Eco mediático de noticias falsas',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Bloqueos masivos de cuentas en redes sociales',
                'description' => 'Bloqueos masivos de cuentas en redes sociales',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Difusión dañina',
                'description' => 'Difusión dañina',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Desastres naturales',
            'description' => 'Desastres naturales',
            'status'      => 1,
        ]);

        Subcategory::create(
            [
                'name'        => 'Terremotos, inundaciones, huracanes, relámpagos (descarga eléctrica), tsunamis, derrumbes, aludes y otros desastres',
                'description' => 'Terremotos, inundaciones, huracanes, relámpagos (descarga eléctrica), tsunamis, derrumbes, aludes y otros desastres',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        );

        $category = Category::create([
            'name'        => 'Incidentes de agresión',
            'description' => 'Incidentes de agresión',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Ciberterrorismo',
                'description' => 'Ciberterrorismo',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Ciberguerra',
                'description' => 'Ciberguerra',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Subversión social',
                'description' => 'Subversión social',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Contenido dañino',
            'description' => 'Contenido dañino',
            'status'      => 1,
        ]);

        Subcategory::create(
            [
                'name'        => 'Fraude',
                'description' => 'Fraude',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        );

        $category = Category::create([
            'name'        => 'Incidentes contra la dignidad y la individualidad',
            'description' => 'Incidentes contra la dignidad y la individualidad',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Pornografía',
                'description' => 'Pornografía',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Ciberacoso',
                'description' => 'Ciberacoso',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Engaño pederasta (Grooming)',
                'description' => 'Engaño pederasta (Grooming)',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Daños físicos',
            'description' => 'Daños físicos',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Afectaciones en el sistema de comunicaciones por fuego, escapes de gas o agua, polución, corrosión, roturas de cables, accidentes automovilísticos o aéreos y otras causas',
                'description' => 'Afectaciones en el sistema de comunicaciones por fuego, escapes de gas o agua, polución, corrosión, roturas de cables, accidentes automovilísticos o aéreos y otras causas',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Robo de equipamiento informático',
                'description' => 'Robo de equipamiento informático',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Acción no autorizada',
            'description' => 'Acción no autorizada',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Uso no autorizado de recursos',
                'description' => 'Uso no autorizado de recursos',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Servicio de TIC ilegal',
                'description' => 'Servicio de TIC ilegal',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Instalación de software no permitido',
                'description' => 'Instalación de software no permitido',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Acceso no autorizado a la administración de sitios web',
                'description' => 'Acceso no autorizado a la administración de sitios web',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Fallas de la infraestructura',
            'description' => 'Fallas de la infraestructura',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Fallo de climatización',
                'description' => 'Fallo de climatización',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Fallo eléctrico',
                'description' => 'Fallo eléctrico',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Fallas técnicas',
            'description' => 'Fallas técnicas',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Fallo del equipamiento',
                'description' => 'Fallo del equipamiento',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Fallo de aplicaciones o servicios',
                'description' => 'Fallo de aplicaciones o servicios',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Plataformas desactualizadas',
                'description' => 'Plataformas desactualizadas',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Interferencias',
            'description' => 'Interferencias',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Radiaciones, pulsos electromagnéticos y otras interferencias',
                'description' => 'Radiaciones, pulsos electromagnéticos y otras interferencias',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Cambios de características de aplicaciones, equipos o componentes y servicios',
                'description' => 'Cambios de características de aplicaciones, equipos o componentes y servicios',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Compromiso de la información',
            'description' => 'Compromiso de la información',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Borrado o modificación de información',
                'description' => 'Borrado o modificación de información',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Publicación o pérdida de información oficial Clasificada',
                'description' => 'Publicación o pérdida de información oficial Clasificada',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Pérdida de datos e información',
                'description' => 'Pérdida de datos e información',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Robo de información',
                'description' => 'Robo de información',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Phishing',
                'description' => 'Phishing',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Sniffers',
                'description' => 'Sniffers',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Hombre en el medio',
                'description' => 'Hombre en el medio',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Escaneo (Puertos y Vulnerabilidades)',
            'description' => 'Escaneo (Puertos y Vulnerabilidades)',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Protocolo FTP',
                'description' => 'Protocolo FTP',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Terminal Server en puerto no estándar',
                'description' => 'Terminal Server en puerto no estándar',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Protocolo RDP',
                'description' => 'Protocolo RDP',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Protocolo VNC',
                'description' => 'Protocolo VNC',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Correos no deseados',
            'description' => 'Correos no deseados',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Cadenas',
                'description' => 'Cadenas',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Servicio SQL',
                'description' => 'Servicio SQL',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Hoax',
                'description' => 'Hoax',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Spam',
                'description' => 'Spam',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Desfiguración de Sitios Web',
            'description' => 'Desfiguración de Sitios Web',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Inclusión local o remota de ficheros',
                'description' => 'Inclusión local o remota de ficheros',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Inyección de código',
                'description' => 'Inyección de código',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Compromiso de las funciones',
            'description' => 'Compromiso de las funciones',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Derecho de autor',
                'description' => 'Derecho de autor',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Robo de credenciales',
                'description' => 'Robo de credenciales',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Suplantación de identidad',
                'description' => 'Suplantación de identidad',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Programas malignos',
            'description' => 'Programas malignos',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Amenaza persistente avanzada (APT)',
                'description' => 'Amenaza persistente avanzada (APT)',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Robot informáticos (Botnet)',
                'description' => 'Robot informáticos (Botnet)',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Gusanos',
                'description' => 'Gusanos',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Secuestro de la información (Ransomware)',
                'description' => 'Secuestro de la información (Ransomware)',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Troyanos',
                'description' => 'Troyanos',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Tráfico con C&C (mando y control)',
                'description' => 'Tráfico con C&C (mando y control)',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Troyanos RAT',
                'description' => 'Troyanos RAT',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Troyanos Ransomware',
                'description' => 'Troyanos Ransomware',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Troyanos Minero',
                'description' => 'Troyanos Minero',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Virus informático',
                'description' => 'Virus informático',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Programas espías (Spyware)',
                'description' => 'Programas espías (Spyware)',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Rootkit',
                'description' => 'Rootkit',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Dialer',
                'description' => 'Dialer',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);

        $category = Category::create([
            'name'        => 'Ataques técnicos o intrusión',
            'description' => 'Ataques técnicos o intrusión',
            'status'      => 1,
        ]);

        Subcategory::insert([
            [
                'name'        => 'Denegación de servicio',
                'description' => 'Denegación de servicio',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Denegación de servicio distribuido (DDoS)',
                'description' => 'Denegación de servicio distribuido (DDoS)',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Ataque por fuerza bruta',
                'description' => 'Ataque por fuerza bruta',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Explotación de vulnerabilidades',
                'description' => 'Explotación de vulnerabilidades',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Cambios de características del Hardware',
                'description' => 'Cambios de características del Hardware',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Cambios de características del software o base de datos',
                'description' => 'Cambios de características del software o base de datos',
                'status'      => 1,
                'category_id' => $category->id,
            ],
            [
                'name'        => 'Manipulación de DNS',
                'description' => 'Manipulación de DNS',
                'status'      => 1,
                'category_id' => $category->id,
            ],
        ]);
    }
}
