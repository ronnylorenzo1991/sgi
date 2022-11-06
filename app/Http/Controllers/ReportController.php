<?php

namespace App\Http\Controllers;

use App\Models\Reports\Entity\Report;
use App\Models\Reports\Repository\ReportRepository;
use Illuminate\Http\Request;

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

        $perPage = (int)$request->get('per_page');
        $page = (int)$request->get('page');

        $reports = $this->reportsRepository->getAll($sortBy, $sortDir, $perPage, $page, ['events', 'availabilities', 'news']);

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
                'message' => 'Noticia eliminada satisfactoriamente'
            ]);

        } catch (\Exception $e) {
            return json_encode([
                'message' => 'Hubo un problema al eliminar los datos'
            ]);
        }
    }
}
