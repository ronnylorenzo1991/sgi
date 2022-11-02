<?php

namespace App\Http\Controllers;

use App\Models\Audits\Repository\AuditRepository;
use Illuminate\Http\Request;

class AuditController extends Controller
{

    private $auditsRepository;

    public function __construct(AuditRepository $auditsRepository)
    {
        $this->auditsRepository = $auditsRepository;
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

        $audits = $this->auditsRepository->getAll($sortBy, $sortDir, $perPage, $page);

        return json_encode($audits);
    }
}
