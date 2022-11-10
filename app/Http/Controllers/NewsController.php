<?php

namespace App\Http\Controllers;

use App\Models\News\Entity\News;
use App\Models\News\Repository\NewsRepository;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::latest('id')->paginate(10);

        return view('news.index', compact('news'));
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

        $news = $this->newsRepository->getAll($sortBy, $sortDir, $perPage, $page);

        return json_encode($news);
    }

    public function store(Request $request)
    {
        try {
            $this->newsRepository->store($request->all());

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
            $this->newsRepository->update($request->all(), $id);

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
            $this->newsRepository->delete($id);

            return json_encode([
                'message' => 'Noticia eliminada satisfactoriamente'
            ]);

        } catch (\Exception $e) {
            return json_encode([
                'message' => 'Hubo un problema al eliminar los datos'
            ]);
        }
    }

    public function getTodayNews() {
        return json_encode($this->newsRepository->getTodayNews());
    }

    public function getDataByDateRange(Request $request) {
        return json_encode($this->newsRepository->getDataByDateRange($request->all()));
    }
}
