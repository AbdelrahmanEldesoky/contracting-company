<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\WorkerSallary;



//use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
class PdfController extends Controller
{
     public function workergeneratePdf($project_id)
   {
    $myProjectDirectory = '/path/to/my/project';


    $project = Project::where('id',$project_id)->get();
       $workers = WorkerSallary::join('workers', 'worker_salaries.worker_id', '=', 'workers.id')
                ->select(DB::raw('sum(add_sallary)as add_sallary,
                                  sum(deduct_sallary)as deduct_sallary,
                                  sum(total_sallary)as total_sallary,
                                  count(worker_salaries.id)as id,
                                  name,workers.sallary'))
                ->where('workers.project_id', '=', $project_id)
                ->where('worker_salaries.Presence','=',1)
                ->groupBy('name','workers.sallary')->get();
    $totals = WorkerSallary::select(DB::raw('sum(add_sallary)as add_sallary,
                sum(deduct_sallary)as deduct_sallary,
                sum(sallary)as sallary,
                sum(total_sallary)as total_sallary'))
                ->where('project_id', '=', $project_id)
                ->where('Presence','=',1)->get();
        $data = 'webjourney.dev';
        $pdf = Pdf::loadView('welcome',compact('data','workers','project','totals'));
        return $pdf->stream('welcome');
   //   return $pdf->download('welcome.pdf');
   }
   public function workerdownloadPdf($project_id)
   {
    $project = Project::where('id',$project_id)->get();
       $workers = WorkerSallary::join('workers', 'worker_salaries.worker_id', '=', 'workers.id')
                ->select(DB::raw('sum(add_sallary)as add_sallary,
                                  sum(deduct_sallary)as deduct_sallary,
                                  sum(total_sallary)as total_sallary,
                                  count(worker_salaries.id)as id,
                                  name,workers.sallary'))
                ->where('workers.project_id', '=', $project_id)
                ->where('worker_salaries.Presence','=',1)
                ->groupBy('name','workers.sallary')->get();
    $totals = WorkerSallary::select(DB::raw('sum(add_sallary)as add_sallary,
                                             sum(deduct_sallary)as deduct_sallary,
                                             sum(sallary)as sallary,
                                             sum(total_sallary)as total_sallary'))
                                             ->where('project_id', '=', $project_id)
                                             ->where('Presence','=',1)->get();



        $data = 'webjourney.dev';
        $pdf = Pdf::loadView('welcome',compact('data','workers','project','totals'));

      return $pdf->download('welcome.pdf');
   }


}
