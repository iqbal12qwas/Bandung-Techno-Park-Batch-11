<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\IndexRepository;
use App\Http\Resources\ListIndex;
use App\Http\Resources\ListIndexCollection;
use App\Traits\ReturnJson;
use DataTables;


class IndexController extends Controller
{
    use ReturnJson;

    protected $indexRepo;

    public function __construct(IndexRepository $index)
    {
        $this->indexRepo = $index;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function indexPaginate(Request $request)
    {
        try {
            if ($request->ajax()) {
                $data = $this->indexRepo->readActivity();
                return Datatables::of($data)
                            ->addIndexColumn()
                            ->addColumn('action', function($row){
                            
                                   $btn = '<button class="btn btn-warning" onClick="show('.$row->id.')">Edit</button><button class="btn btn-danger" onClick="destroy('.$row->id.')">Delete</button>';
                            
                                    return $btn;
                            })
                            ->rawColumns(['action'])
                            ->make(true);
            }
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }
    }

    public function read()
    {
        try {
            $datas = $this->indexRepo->readActivity();
            return view('read')->with(['data' => $datas]);
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }
    }

    public function paginate(Request $request)
    {
        try {
            $page = (int) $request->page;
            $per_page = (int) $request->per_page < 1 ? 10 : $request->per_page;
            $datas = $this->indexRepo->paginationActivity($page, $per_page);
            $result = new ListIndexCollection($datas);
            return $this->returnJsonSuccess($result->toArray($request));
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->indexRepo->saveActivity($request);
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = $this->indexRepo->activityById($id);
            $data_month = $this->indexRepo->listMonth();
            $data_method = $this->indexRepo->listMethod();
            return view('edit')->with([
                'data' => $data, 'data_month' => $data_month, 'data_method' => $data_method
            ]);
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->indexRepo->updateActivity($request, $id);
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            $this->indexRepo->deleteActivity($id);
        } catch (\Exception $e) {
            return $this->returnJsonFailed(['message' => $e->getMessage()]);
        }
    }

    public function getMonth(){
        $data = $this->indexRepo->listMonth();
        return response()->json($data);
    }


    public function getMethod(){
        $data = $this->indexRepo->listMethod();
        return response()->json($data);
    }
}