<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\ActivityModel;
use App\Models\MonthModel;
use App\Models\MethodModel;
use Carbon\Carbon;

class IndexRepository 
{
    private function getOnlyMonthNumber($date) {
        $date_start = Carbon::parse($date)->format('m');
        $firstStringCharacter = substr($date_start, 0, 1);
        if ($firstStringCharacter == '0') {
            $date_start = Str::substr($date_start, 1);
        }
        
        return $date_start;
    }

    public function readActivity()
    {
        $data = ActivityModel::join('tb_months', 'tb_months.id', '=', 'tb_activities.id_months')
                             ->join('tb_methods', 'tb_methods.id', '=', 'tb_activities.id_methods')
                             ->select('tb_activities.id as id','tb_methods.name as name_methods', 'tb_months.name as name_months', 'activity', 'date_start', 'date_end')
                             ->where('tb_activities.is_deleted', false)
                             ->get();

        return $data;
    }

    public function read()
    {
        $data = ActivityModel::all();

        return $data;
    }

    public function paginationActivity($page, $per_page)
    {
        $limit = $per_page;
        $page = ($page == 0) ? 1 : $page;
        $offset = ($page - 1) * $limit;
    
        $meta = array(
                "page"=> (int)$page,
                "per_page"=> $limit,
                "total"=> 0,
                "total_page"=> 0
        ); 

        $data = ActivityModel::join('tb_months', 'tb_months.id', '=', 'tb_activities.id_months')
                             ->join('tb_methods', 'tb_methods.id', '=', 'tb_activities.id_methods')
                             ->select('tb_activities.id as id','tb_methods.name as name_methods', 'tb_months.name as name_months', 'activity', 'date_start', 'date_end')
                             ->where('tb_activities.is_deleted', false)
                             ->paginate($limit);

        return $data;
    }

    public function saveActivity($request)
    {
        $data['id_months'] = $this->getOnlyMonthNumber($request->date_start);
        $data['id_methods'] = $request->method;
        $data['activity'] = $request->activity;
        $data['date_start'] = $request->date_start;
        $data['date_end'] = $request->date_end;
        $data['is_deleted'] = false;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();
        ActivityModel::insert($data);
    }

    public function activityById($id)
    {
        $data = ActivityModel::findOrFail($id);

        return $data;
    }

    public function updateActivity($request, $id)
    {
        $data = ActivityModel::findOrFail($id);
        $data->id_months = $this->getOnlyMonthNumber($request->date_start);
        $data->id_methods = $request->method;
        $data->activity = $request->activity;
        $data->date_start = $request->date_start;
        $data->date_end = $request->date_end;
        $data->is_deleted = false;
        $data->updated_at = Carbon::now();
        $data->save();
    }

    public function deleteActivity($id)
    {
        $data = ActivityModel::findOrFail($id);
        $data->is_deleted = true;
        $data->deleted_at = Carbon::now();
        $data->save();
    }

    public function listMonth()
    {
        $data = MonthModel::orderBy('id', 'ASC')->get();

        return $data;
    }

    public function listMethod()
    {
        $data = MethodModel::orderBy('id', 'ASC')->get();

        return $data;
    }
}