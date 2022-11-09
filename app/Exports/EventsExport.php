<?php

namespace App\Exports;

use App\Models\Countries\Entity\country;
use \App\Models\Events\Entity\Event;
use App\Models\Events\Repository\EventRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventsExport implements FromCollection, WithHeadings, WithStyles
{
    private $eventRepository;
    private $filters;

    public function __construct(EventRepository $eventRepository, $filters)
    {
        $this->eventRepository = $eventRepository;
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $events = $this->eventRepository->getExportQuery($this->filters);

        foreach ($events as $event) {
            $nationalIps = [];
            $nationalMinistries = [];
            $nationalEntities = [];
            $nationalLinks = [];

            $foreignIps = [];
            $foreingnCountries = [];
            $foreignEntities = [];
            if ($event->nodes) {
                foreach ($event->nodes as $node) {
                    if ($node->country->id === get_national_id()) {
                        $nationalIps[] = $node->ip->address;
                        $nationalMinistries[] = $node->ministry->name;
                        $nationalEntities[] = $node->entity->name;
                        $nationalLinks[] = $node->internetLink->name;
                    } else {
                        $foreignIps[] = $node->ip->address;
                        $foreingnCountries[] = $node->country->name;
                        $foreignEntities[] = $node->entity->name;
                    }
                }
            }
            $event['national_ips'] = implode(', ', $nationalIps);
            $event['national_ministries'] = implode(', ', $nationalMinistries);
            $event['national_entities'] = implode(', ', $nationalEntities);
            $event['national_links'] = implode(', ', $nationalLinks);

            $event['foreign_ips'] = implode(', ', $foreignIps);
            $event['foreign_countries'] = implode(', ', $foreingnCountries);
            $event['foreign_entities'] = implode(', ', $foreignEntities);

        }

        return $events;
    }

    public function headings(): array
    {
        return [
            'id'                  => 'Id',
            'date'                => 'Fecha',
            'number'              => 'Numero',
            'category_name'       => 'Categoría',
            'subcategory_name'    => 'Subcategoría',
            'observations'        => 'Observaciones',
            'is_national_source'  => 'Origen/Destino',
            'detected_by_name'    => 'Detectado Por',
            'contribute_name'     => 'Tributa',
            'national_ips'        => 'Direcciones Nacionales',
            'national_ministries' => 'Ministerios',
            'national_entities'   => 'Entidades Involucradas',
            'national_links'      => 'Nombre del Enlace',
            'foreign_ips'         => 'Direcciones Extranjeras',
            'foreign_countries'   => 'Pais Involucrado',
            'foreign_entities'    => 'Entidades Extranjeras',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
