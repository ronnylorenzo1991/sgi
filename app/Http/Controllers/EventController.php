<?php

namespace App\Http\Controllers;

use App\Exports\EventsExport;
use App\Http\Requests\EventRequest;
use App\Models\Events\Entity\Event;
use App\Models\Events\Repository\EventRepository;
use App\Models\Subcategories\Entity\Subcategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
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

        $events = $this->eventRepository->getAll($sortBy, $sortDir, $perPage, $page, 'nodes', 'nodes.ip');

        return json_encode($events);
    }

    public function create()
    {
        $subcategories = Subcategory::all()->pluck('name', 'id');

        return view('event.create', compact('subcategories'));
    }

    public function store(EventRequest $request)
    {
        try {
            $this->eventRepository->store($request->all());

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

    public function update(EventRequest $request, $id)
    {
        try {
            $this->eventRepository->update($request->all(), $id);

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

    public function destroy($id)
    {
        try {
            $this->eventRepository->delete($id);

            return back()->with('success', 'Elemento Eliminado Correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Hubo Problemas al Eliminar el Elemento');
        }
    }

    public function totalByMonth(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalByMonth($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalsByEntities(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsByEntities($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalByCategories(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsByCategories($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function delete($id)
    {
        try {
            $this->eventRepository->delete($id);

            return json_encode([
                'message' => 'Evento eliminado satisfactoriamente',
            ]);

        } catch (\Exception $e) {
            return json_encode([
                'message' => 'Hubo un problema al eliminar los datos',
            ]);
        }
    }

    public function export()
    {
        return Excel::download(new EventsExport($this->eventRepository), 'events.xlsx');
    }

    public function totalBySubcategories(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsBySubcategories($filterParams);

        foreach ($labels as $key => $label) {
            $labels[$key] = strlen($label) > 30 ? substr($label, 0, 30)."..." : $label;
        }

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalByDetectedBy(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsBySource($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalByMinistries(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsByMinistries($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalBySourceDestiny(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsBySourceDestiny($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalByEntitiesNationals(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsByNationalEntities($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalByCountriesInvolved(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsByCountry($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalByForeignEntitiesInvolved(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsByForeignEntities($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalByContribute(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsByContributes($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }

    public function totalsBySourceTarget(Request $request)
    {
        $filterParams = [
            'startDate' => $request->get('startDate'),
            'endDate'   => $request->get('endDate'),
        ];

        [$totals, $labels] = $this->eventRepository->getTotalsSourceTarget($filterParams);

        return json_encode(['totals' => $totals, 'labels' => $labels]);
    }
}
