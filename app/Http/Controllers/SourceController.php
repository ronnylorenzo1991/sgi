<?php

namespace App\Http\Controllers;

use App\Models\Sources\Entity\Source;
use App\Models\Sources\Repository\SourceRepository;
use Illuminate\Http\Request;

class SourceController extends Controller
{
    private $sourceRepository;

    public function __construct(SourceRepository $sourceRepository)
    {
        $this->sourceRepository = $sourceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sources = Source::latest('id')->paginate(10);

        return view('source.index', compact('sources'));
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

        $sources = $this->sourceRepository->getAll($sortBy, $sortDir, $perPage, $page);

        return json_encode($sources);
    }

    public function store(Request $request)
    {
        try {
            $this->sourceRepository->store($request->all());

            return json_encode([
                'message' => 'Elemento guardado satisfactoriamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un problema al guardar los datos',
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->sourceRepository->update($request->all(), $id);

            return json_encode([
                'message' => 'Elemento guardado satisfactoriamente',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Hubo un problema al guardar los datos',
            ], 400);
        }
    }

    public function delete($id)
    {
        try {
            $this->sourceRepository->delete($id);

            return json_encode([
                'message' => 'Sitio eliminada satisfactoriamente'
            ]);

        } catch (\Exception $e) {
            return json_encode([
                'message' => 'Hubo un problema al eliminar los datos'
            ]);
        }
    }
}
