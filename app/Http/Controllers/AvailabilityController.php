<?php

namespace App\Http\Controllers;

use App\Http\Requests\AvailabilityStoreRequest;
use App\Http\Requests\AvailabilityUpdateRequest;
use App\Models\Availability\Repository\AvailabilityRepository;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    private $availabilityRepository;

    public function __construct(AvailabilityRepository $availabilityRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
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

        $availabilities = $this->availabilityRepository->getAll($sortBy, $sortDir, $perPage, $page);

        return json_encode($availabilities);
    }

    public function store(AvailabilityStoreRequest $request)
    {
        try {
            $this->availabilityRepository->store($request->all());

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

    public function update(AvailabilityUpdateRequest $request, $id)
    {
        try {
            $this->availabilityRepository->update($request->all(), $id);

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
            $this->availabilityRepository->delete($id);

            return json_encode([
                'message' => 'Categoría eliminada satisfactoriamente'
            ]);

        } catch (\Exception $e) {
            return json_encode([
                'message' => 'Hubo un problema al eliminar los datos'
            ]);
        }
    }

    public function getTodayAvailabilities() {
        return json_encode($this->availabilityRepository->getTodayAvailabilities());
    }

    public function getDataByDateRange(Request $request) {
        return json_encode($this->availabilityRepository->getDataByDateRange($request->all()));
    }
}
