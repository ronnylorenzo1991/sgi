<?php

namespace App\Http\Controllers;

use App\Models\InternetLinks\Entity\InternetLink;
use App\Models\InternetLinks\Repository\InternetLinkRepository;
use Illuminate\Http\Request;

class InternetLinkController extends Controller
{

    private $entityRepository;

    public function __construct(InternetLinkRepository $entityRepository)
    {
        $this->entityRepository = $entityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $internetLinks = InternetLink::latest('id')->paginate(10);

        return view('entity.index', compact('internetLinks'));
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

        $internetLinks = $this->entityRepository->getAll($sortBy, $sortDir, $perPage, $page);

        return json_encode($internetLinks);
    }

    public function store(Request $request)
    {
        try {
            $this->entityRepository->store($request->all());

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
            $this->entityRepository->update($request->all(), $id);

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
            $this->entityRepository->delete($id);

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
