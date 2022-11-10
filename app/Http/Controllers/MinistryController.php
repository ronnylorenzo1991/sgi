<?php

namespace App\Http\Controllers;

use App\Models\Ministries\Entity\Ministry;
use App\Models\Ministries\Repository\MinistryRepository;
use Illuminate\Http\Request;

class MinistryController extends Controller
{

    private $ministryRepository;

    public function __construct(MinistryRepository $ministryRepository)
    {
        $this->ministryRepository = $ministryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ministries = Ministry::latest('id')->paginate(10);

        return view('ministry.index', compact('ministries'));
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

        $ministries = $this->ministryRepository->getAll($sortBy, $sortDir, $perPage, $page);

        return json_encode($ministries);
    }

    public function store(Request $request)
    {
        try {
            $this->ministryRepository->store($request->all());

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
            $this->ministryRepository->update($request->all(), $id);

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
            $this->ministryRepository->delete($id);

            return json_encode([
                'message' => 'Elemento eliminado satisfactoriamente'
            ]);

        } catch (\Exception $e) {
            return json_encode([
                'message' => 'Hubo un problema al eliminar los datos'
            ]);
        }
    }
}
