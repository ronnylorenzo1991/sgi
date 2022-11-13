<?php

namespace App\Http\Controllers;

use App\Models\Contributes\Entity\Contribute;
use App\Models\Contributes\Repository\ContributeRepository;
use Illuminate\Http\Request;

class ContributeController extends Controller
{
    private $contributeRepository;

    public function __construct(ContributeRepository $contributeRepository)
    {
        $this->contributeRepository = $contributeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contributes = Contribute::latest('id')->paginate(10);

        return view('contribute.index', compact('contributes'));
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

        $contributes = $this->contributeRepository->getAll($sortBy, $sortDir, $perPage, $page);

        return json_encode($contributes);
    }

    public function store(Request $request)
    {
        try {
            $this->contributeRepository->store($request->all());

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
            $this->contributeRepository->update($request->all(), $id);

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
            $this->contributeRepository->delete($id);

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
