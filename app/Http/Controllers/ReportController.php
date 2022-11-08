<?php

namespace App\Http\Controllers;

use App\Models\Reports\Entity\Report;
use App\Models\Reports\Repository\ReportRepository;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Shared\Converter;

class ReportController extends Controller
{
    private $reportsRepository;

    public function __construct(ReportRepository $reportsRepository)
    {
        $this->reportsRepository = $reportsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::latest('id')->paginate(10);

        return view('reports.index', compact('reports'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $sortData = $request->get('sort') ? preg_split("/[\s|]+/", $request->get('sort')) : [];

        $sortBy = 'id';
        $sortDir = 'desc';

        if (!empty($sortData)) {
            $sortBy = $sortData[0];
            $sortDir = $sortData[1];
        }

        $perPage = (int) $request->get('per_page');
        $page = (int) $request->get('page');

        $reports = $this->reportsRepository->getAll($sortBy, $sortDir, $perPage, $page,
            ['events', 'availabilities', 'news']);

        return json_encode($reports);
    }

    public function store(Request $request)
    {
        try {
            $this->reportsRepository->store($request->all());

            return json_encode([
                'message' => 'Elemento guardado satisfactoriamente',
            ]);

        } catch (\Exception $e) {
            dd($e);

            return response()->json([
                'message' => 'Hubo un problema al guardar los datos',
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->reportsRepository->update($request->all(), $id);

            return json_encode([
                'message' => 'Elemento guardado satisfactoriamente',
            ]);

        } catch (\Exception $e) {
            dd($e);

            return response()->json([
                'message' => 'Hubo un problema al guardar los datos',
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $this->reportsRepository->delete($id);

            return json_encode([
                'message' => 'Noticia eliminada satisfactoriamente',
            ]);

        } catch (\Exception $e) {
            return json_encode([
                'message' => 'Hubo un problema al eliminar los datos',
            ]);
        }
    }

    public function exportWord($id)
    {
        try {
            $report = $this->reportsRepository->findOrFail($id);

            $template = new \PhpOffice\PhpWord\TemplateProcessor(asset('assets/word_templates/report_basic_template.docx'));

            $date = new \DateTime($report->date);
            $news = $this->reportsRepository->getNewsFormatted($id);
            $sourceTrojanEvents = $this->reportsRepository->getTrojanEvents($id, 'source');
            $targetTrojanEvents = $this->reportsRepository->getTrojanEvents($id, 'target');
            $sourceEvents = $this->reportsRepository->getEvents($id, 'source');
            $targetEvents = $this->reportsRepository->getEvents($id, 'target');
            $availabilitiesChart = $this->reportsRepository->getAvailabilitiesChartData($id);
            $categoriesChart = $this->reportsRepository->getChartData($id, 'category');
            $entitiesChart = $this->reportsRepository->getChartData($id, 'entity');

            $categories = [];
            $entities = [];

            foreach ($report->events as $event) {
                if (!in_array($event->category, $categories)) {
                    $categories[] = $event->category;
                }

                if (!in_array($event->detectedBy, $entities)) {
                    $entities[] = $event->detectedBy;
                }
            }

            if (real_empty($sourceTrojanEvents)) {
                $template->cloneBlock('block_source_trojan_event', 0, true, true);
            } else {
                $template->cloneBlock('block_source_trojan_event', 0, true, false, $sourceTrojanEvents);
            }
            if (real_empty($targetTrojanEvents)) {
                $template->cloneBlock('block_target_trojan_event', 0, true, true);
            } else {
                $template->cloneBlock('block_target_trojan_event', 0, true, false, $targetTrojanEvents);
            }
            if (real_empty($sourceEvents)) {
                $template->cloneBlock('block_source_event', 0, true, true);
            } else {
                $template->cloneBlock('block_source_event', 0, true, false, $sourceEvents);
            }
            if (real_empty($targetEvents)) {
                $template->cloneBlock('block_target_event', 0, true, true);
            } else {
                $template->cloneBlock('block_target_event', 0, true, false, $targetEvents);
            }

            $template->setValue('date', $date->format('Y-m-d'));
            $template->setValue('number', $report->number);
            $template->setValue('events_total', $report->events->count());
            $template->setValue('categories_total', count($categories));
            $template->setValue('categories_with_total', $this->reportsRepository->getWithTotalText($id, 'category'));
            $template->setValue('entities_total', count($entities));
            $template->setValue('entities_with_total', $this->reportsRepository->getWithTotalText($id, 'entity'));
            $template->cloneBlock('block_news', 0, true, false, $news);
            $availabilityChart = new \PhpOffice\PhpWord\Element\Chart('column', $availabilitiesChart['labels'], $availabilitiesChart['series']);
            $availabilityChart->getStyle()->setWidth(Converter::inchToEmu(6.5))->setHeight(Converter::inchToEmu(2.5));
            $categoryChart = new \PhpOffice\PhpWord\Element\Chart('column', $categoriesChart['labels'], $categoriesChart['series']);
            $categoryChart->getStyle()->setWidth(Converter::inchToEmu(6.5))->setHeight(Converter::inchToEmu(2.5));
            $entityChart = new \PhpOffice\PhpWord\Element\Chart('column', $entitiesChart['labels'], $entitiesChart['series']);
            $entityChart->getStyle()->setWidth(Converter::inchToEmu(6.5))->setHeight(Converter::inchToEmu(2.5));
            $template->setChart('chart_availability', $availabilityChart);
            $template->setChart('chart_category', $categoryChart);
            $template->setChart('chart_entity', $entityChart);
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
            $template->saveAs($tempFile);

            $headers = [
                "Content-Type: application/octet-stream",
            ];

            return response()->download($tempFile, 'salida.docx', $headers)->deleteFileAfterSend(true);

            return json_encode([
                'message' => 'Noticia eliminada satisfactoriamente',
            ]);

        } catch (\PhpOffice\PhpWord\Exception\Exception $e) {
            return json_encode([
                'message' => 'Hubo un problema al exportar los datos',
            ]);
        }
    }
}
