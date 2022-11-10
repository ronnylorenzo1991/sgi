<?php

namespace App\Http\Controllers;

use App\Exports\EventsExport;
use App\Http\Requests\EventStoreRequest;
use App\Models\Events\Repository\EventRepository;
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
        $events = $this->eventRepository->getAllFiltered($request->all());

        return json_encode($events);
    }

    public function store(EventStoreRequest $request)
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

    public function update(EventStoreRequest $request, $id)
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

    public function export(Request $request)
    {
        return Excel::download(new EventsExport($this->eventRepository, $request->all()), 'events.xlsx');
    }

    public function getTodayEvents() {
        return json_encode($this->eventRepository->getTodayEvents());
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
