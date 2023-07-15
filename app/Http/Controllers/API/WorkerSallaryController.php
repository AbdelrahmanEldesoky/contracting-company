<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\Mobile;
use App\Models\ESP;
use App\Models\ESPSO;
use App\Models\MobileApp;
use App\Models\WorkerSallary;
use Illuminate\Http\Request;
use DB;

class WorkerSallaryController extends Controller
{
    
    
    public function pdfpp()
    {
        
     return View('invoice-print');
    }
    
    
    
    
    
    public function get(int $project_id, $date)
    {
      $worker = Worker::where('project_id', '=', $project_id)->where('user_id', auth()->user()->id)->get();

      foreach ($worker as $workers){
      $count= WorkerSallary::where('project_id', '=', $project_id)
                           ->where('worker_id',$workers->id)
                           ->whereDate('date_at', $date)
                           ->count();
    if( $count == 0){
   // $time = strtotime($date);
    WorkerSallary::create([
            'worker_id'=> $workers->id ,
            'project_id' =>$workers->project_id,
            'user_id'=>auth()->user()->id,
            'sallary' => $workers->	sallary,
            'date_at'=> $date
        ]);}
      }

  $worker_get = WorkerSallary::join('workers', 'workers.id', '=', 'worker_salaries.worker_id')
            ->select('worker_salaries.id','workers.name','worker_salaries.hours', 'workers.mobile',
            'worker_salaries.sallary','add_sallary','deduct_sallary','total_sallary','Presence','date_at')
    ->where('worker_salaries.project_id', '=', $project_id)
    ->where('workers.user_id', '=', auth()->user()->id)
    ->where( 'worker_salaries.date_at','=',$date)->get();

    return response()->json([
             'success'   => true,
             'msg'       => '',
             'data'      => $worker_get
    ]);
    }


    public function sallarydaily(Request $request, $id)
    {
        if($request->statement ==null )
       { $statement='-';}else{$statement = $request->statement;}

    $sallarys=WorkerSallary::where('id', $id)->sum('sallary');

    $sallary = WorkerSallary::where('id', $id);

    if($request->Presence == null) {
        $presence = WorkerSallary::where('id', $id)->value('presence');
        $hours = WorkerSallary::where('id', $id)->value('hours');

    }if($request->Presence == '0') {
        $sallary->update([
            'Presence' => 0,
            'hours' => 0,
            'add_sallary'=> 0,
            'deduct_sallary'=> 0,
            'total_sallary'=> 0
        ]);

    return response()->json([
            'success'   => true,
            'msg'       => '',
            'data'      => 'total_sallary = 0'
       ]);

    }elseif($request->Presence == '1') {
        $presence = 1;
        $hours = 8;
    }

    if($request->add_hours == null) {
        $add_sallary = WorkerSallary::where('id', $id)->value('add_sallary');
    }else if($request->add_hours != null){
        $hours = 8 + $request->add_hours;
        $add_sallary = ($sallarys /8) * $request->add_hours;
    }

    if($request->deduct_hours == null) {
        $deduct_sallary = WorkerSallary::where('id', $id)->value('deduct_sallary');
    }else if($request->deduct_hours != null){
        $hours = 8 - $request->deduct_hours;
        $deduct_sallary = ($sallarys /8) * $request->deduct_hours;
    }


    if($request->deduct_money == null && $request->deduct_hours ==null ) {
            $deduct_sallary = WorkerSallary::where('id', $id)->value('deduct_sallary');
    }else if($request->deduct_money != null){
        $deduct_sallary =  $request->deduct_money;
    }

    if($request->add_money == null && $request->add_hours == null) {
            $add_sallary = WorkerSallary::where('id', $id)->value('add_sallary');
    }else if($request->add_money != null){
            $add_sallary =  $request->add_money;
    }

        $totals = $sallarys + $add_sallary - $deduct_sallary;

        $sallary = WorkerSallary::where('id', $id);

        $sallary->update([
            'Presence' => $presence,
            'hours' => $hours,
            'add_sallary'=> $add_sallary,
            'statement' =>$statement,
            'deduct_sallary'=> $deduct_sallary,
            'total_sallary'=> $totals
        ]);
    return response()->json([
            'success'   => true,
            'msg'       => '',
            'data'      => 'total_sallary = '. $totals
   ]);
    }





    public function sallarydailydetails($id){
        $details=WorkerSallary::where('id', $id)->get();
        return response()->json([
            'success'   => true,
            'msg'       => '',
            'data'      => $details
        ]);
    }


    public function m(Request $request)
    {
        $api = Mobile::where ('id',1);
        $api ->update([
                'temperature'=>$request->temperature ,
                'tankLevel'=>$request->tankLevel,
                'humidity'=>$request->humiditySoil ,
                'humiditySoil'=>$request->humidity,
                'humiditySoil'=>$request->humidity,
                'LIGHT'=>$request->LIGHT,
                'gaz'=>$request->gaz,
                //'button'=>$request->button,
                ]);
        $b= Mobile::where ('id',1)->value('button');
          return response()->json($b);
    }
    
    



    public function control(Request $request)
    {
        $api = Mobile::where ('id',1);
        $api ->update([
                'button'=>$request->button,
                ]);
        $b= Mobile::where ('id',1)->value('button');
           return response()->json([
            'success' => true,
            'msg'     => '',
            'data'    => $b
        ]);        
               
    }
    



    public function esp_post_mob(Request $request)
    {
        $api = ESP::where ('id',1);
        $api ->update([
                'button'=>$request->button,
                ]);
        $b= Mobile::where ('id',1)->value('button');
           return response()->json([
            'success' => true,
            'msg'     => '',
            'data'    => $b
        ]);        
               
    }



    public function esp32(Request $request)
    {
        
        $api = ESP::find(1);
        $api ->update([
                'Gas'=>$request->Gas ,
                'irrigation'=>$request->irrigation,
                'temp'=>$request->temp ,
                'humi'=>$request->humi ,
                'water'=>$request->water ,
                'firesensorDigital'=>$request->firesensorDigital,
                'sensor_output_pir'=>$request->sensor_output_pir ,
                'rainDigital'=>$request->rainDigital ,
                ]);
        $b= ESP::where ('id',1)->value('button');
          return response()->json($b);
    }
  
    public function esp23_get_mob(Request $request)
    {
        $api = ESP::get();
          return response()->json([
            'success' => true,
            'msg'     => '',
            'data'    => $api
        ]);
    }  


    
    public function d4000(Request $request)
    {



            $api = MobileApp::where ('id',1);
            $api ->update([
                'rate'=>$request->rate ,
             
                ]);
    $b= Mobile::where ('id',1)->value('button');
          return response()->json($b);
    }
    
    
    
    public function espso(Request $request)
    {



     //   return $request->all();

        
        
        $Hydrone= $request->Hydrone_ /40;
        
        $api = ESPSO::create([
        'PM2_5' => $request->PM2_5 +1, 
        'Hydrone_' =>$Hydrone,   //   40
        'no2' =>$request->no2 /80,            //    29
        'Humidite' =>$request->Humidite,      //    59
        'Temperature' =>$request->Temperature, // 29
        'co2_' =>$request->co2_ /3.6,            // 476
        'co_' =>$request->co_ / 220,             // 8
                ]);
        return response()->json('sofi :) :) :)');
    }
    
    public function espnow(Request $request)
    {
    
     $max = ESPSO::max('id');
     
     $api = ESPSO::where('id',$max)->get();
     
    $PM2_5 = $api[0]->PM2_5;
     
     
       if($PM2_5 >=0 && $PM2_5<=12){
         $PM2_5_text = 'Good';
         $PM2_5_note ='Little to no impact on health';
     }else if($PM2_5 >=12.1 && $PM2_5<=35.4){
         $PM2_5_text = 'Moderate';
         $PM2_5_note ='Reduce the gaz level';
     
     }else if($PM2_5 >=35.5 && $PM2_5<=55.4){
         $PM2_5_text = 'Unhealthy for Sensitive Groups';
         $PM2_5_note ='Risk:stop the gas  stove and sources of combustion';
     }else if($PM2_5 >=55.5 && $PM2_5<=150.4){
         $PM2_5_text = 'Unhealthy';
         $PM2_5_note ='Enhance indoor ventilation';
     }else if($PM2_5 >=150.5 && $PM2_5<=250.4){
         $PM2_5_text = 'Very Unhealthy';
         $PM2_5_note ='Open windows--.';
     }else if($PM2_5 >=250.5 && $PM2_5<=500.4){
         $PM2_5_text = 'Hazardou';
         $PM2_5_note ='Neccesity of opening windowsUsing air purfiers';
     }



    $Hydrone_ = $api[0]->Hydrone_;

    if($Hydrone_ >=0 && $Hydrone_<=12){
         $Hydrone__text = 'Good';
          $Hydrone__note = 'Little to no impact on health';
     }else if($Hydrone_ >=12.1 && $Hydrone_<=35.4){
         $Hydrone__text = 'Moderate';
         $Hydrone__note = 'Reduce the gaz level';

     }else if($Hydrone_ >=35.5 && $Hydrone_<=55.4){
         $Hydrone__text = 'Unhealthy for Sensitive Groups';
         $Hydrone__note = 'Enhance indoor ventilation';
     }else if($Hydrone_ >=55.5 && $Hydrone_<=150.4){
         $Hydrone__text = 'Unhealthy';
         $Hydrone__note = 'Enhance indoor ventilation';
     }else if($Hydrone_ >=150.5 && $Hydrone_<=250.4){
         $Hydrone__text = 'Very Unhealthy';
         $Hydrone__note = 'Open windows--.';
     }else if($Hydrone_ >=250.5 && $Hydrone_<=500.4){
         $Hydrone__text = 'Hazardou';
         $Hydrone__note = 'Neccesity of opening windowsUsing air purfiers';
     }

    $no2 = $api[0]->no2;

   if($no2 >=0 && $no2<=53){
         $no2_text = 'Good';
         $no2_note = 'Little to no impact on health';
     }else if($no2 >=54 && $no2<=100){
         $no2_text = 'Moderate';
         $no2_note = 'Reduce the gaz level';
         
     }else if($no2 >=101 && $no2<=360){
         $no2_text = 'Unhealthy for Sensitive Groups';
         $no2_note = 'Enhance indoor ventilation';
     }else if($no2 >=361 && $no2<=649){
         $no2_text = 'Unhealthy';
         $no2_note = 'Enhance indoor ventilation';
     }else if($no2 >=650 && $no2<=1249){
         $no2_text = 'Very Unhealthy';
         $no2_note = 'Open windows--.';
     }else if($no2 >=1250 && $no2<=1649){
         $no2_text = 'Hazardou';
         $no2_note = 'Neccesity of opening windowsUsing air purfiers';
     }

    $co2_ = $api[0]->co2_*1;

   if($co2_ >=0 && $co2_<=400){
         $co2_text = 'Good';
         $co2_note = 'Little to no impact on health';
     }else if($co2_ >=401 && $co2_<=800){
         $co2_text = 'Moderate';
         $co2_note = 'Reduce the gaz level';
     
     }else if($co2_ >=801 && $co2_<=1600){
         $co2_text = 'Unhealthy for Sensitive Groups';
         $co2_note = 'Enhance indoor ventilation';
     }else if($co2_ >=1601 && $co2_<=2500){
         $co2_text = 'Unhealthy';
         $co2_note = 'Enhance indoor ventilation';
     }else if($co2_ >=2501 && $co2_<=3500){
         $co2_text = 'Very Unhealthy';
         $co2_note = 'Open windows--.';
     }else if($co2_ >=3501 && $co2_<=7000){
         $co2_text = 'Hazardou';
         $co2_note = 'Neccesity of opening windowsUsing air purfiers';
     }
     
  $co_ = $api[0]->co_;

   if($co_ >=0 && $co_<=4.4){
         $co_text = 'Good';
         $co_note = 'Little to no impact on health';
     }else if($co_ >=4.5 && $co_<=9.4){
         $co_text = 'Moderate';
         $co_note = 'Reduce the gaz level';

     
     }else if($co_ >=9.5 && $co_<=12.4){
         $co_text = 'Unhealthy for Sensitive Groups';
         $co_note = 'Enhance indoor ventilation';

     }else if($co_ >=12.5 && $co_<=15.4){
         $co_text = 'Unhealthy';
         $co_note = 'Enhance indoor ventilation';

     }else if($co_ >=15.5 && $co_<=30.4){
         $co_text = 'Very Unhealthy';
         $co_note = 'Open windows--.';

     }else if($co_ >=30.5 && $co_<=40.4){
         $co_text = 'Hazardou';
         $co_note = 'Neccesity of opening windowsUsing air purfiers';
     }
     
     
       $ex= (object) [
                'success'   => true,
                'msg'   => '',
                'data'=> $api[0],
                'PM2_5_text' =>$PM2_5_text,
                'no2_text' => $no2_text,
                'Hydrone__text'=> $Hydrone__text,
                'co2_text'=>$co2_text,
                'co_text'=> $co_text,
                
                
                'PM2_5_note' =>$PM2_5_note,
                'no2_note' =>$no2_note,
                'Hydrone__note'=>' ',
                'co2_note'=>' ',
                'co_note'=> $co_note,
            ];
     return response()->json($ex);
    }
        public function espall(Request $request)
    {

     $api = ESPSO::get();
          return response()->json([
            'success' => true,
            'msg'     => '',
            'data'    => $api
        ]);
    }
    
    public function espt(Request $request)
    {
        
        
      $api =  ESPSO::select( DB::raw( 'AVG( PM2_5 ) as PM2_5 ,AVG( Hydrone_ ) as Hydrone_ ,AVG( no2 ) as no2,
      AVG( Humidite ) as Humidite,AVG( Temperature ) as Temperature,AVG( co2_ ) as co2,AVG( co_ ) as co' ) )
	    ->get();
        
    
       $ex= (object) [
                'success'   => true,
                'msg'   => '',
                'data'=> $api[0],
            ];
    
    return response()->json($ex);
    }
    
    
    
    public function nesba(Request $request)
    {
         $max = ESPSO::max('id');
        
      $api =  ESPSO::select(DB::raw('sum(PM2_5)*50/35 as PM2_5, 
                                    sum(Hydrone_)*50/40 as Hydrone_,
                                    sum(no2)*50/213 as no2,
                                    sum(Humidite) as Humidite,
                                    sum(Temperature) as Temperature,
                                    sum(co2_)*50/1000  co2_,
                                    sum(co_)*50/30 as co_') )->where ('id',$max)->get();
        
    
       $ex= (object) [
                'success'   => true,
                'msg'   => '',
                'data'=> $api[0],
            ];
    
    return response()->json($ex);
    }
    
    
    
    public function moasher(Request $request)
    {
         $max = ESPSO::max('id');
        
        $PM2_5s = ESPSO::where('id',$max)->value('PM2_5');
        $Hydrone_s = ESPSO::where('id',$max)->value('Hydrone_');
        $no2s = ESPSO::where('id',$max)->value('no2');
        $Humidite = ESPSO::where('id',$max)->value('Humidite');
        $Temperature = ESPSO::where('id',$max)->value('Temperature');
        $co2_s = ESPSO::where('id',$max)->value('co2_');
        $co_s = ESPSO::where('id',$max)->value('co_');
        
        
        $PM2_5 = $PM2_5s*50/35;
        $Hydrone_ = $Hydrone_s*50/40;
        $no2 = $no2s*50/213;
        $co2_ = $co2_s*50/1000;
        $co_  = $co_s*50/30 ;
        
        
        if($PM2_5 > ($Hydrone_ && $no2    &&  $co2_  &&  $co_)){
             $api =$PM2_5  ;       
        }else if ($Hydrone_ >= ($PM2_5  &&  $no2    &&  $co2_  &&  $co_)){
            $api =  $Hydrone_ ;
        }else if ($no2>= ($PM2_5  &&  $Hydrone_    &&  $co2_  &&  $co_)){
            $api =$no2 ;
        }else if ( $co2_>= ($PM2_5  &&  $Hydrone_  &&  $no2     &&  $co_)){
            $api =$co2_;
        }else if ( $co_>= ($PM2_5  &&  $Hydrone_  &&  $no2   &&  $co2_)){
            $api = $co_;
        }
        
        
         if($api >=0 && $api<=50){
         $api_text = 'Good';
       
     }else if($api >=51 && $api<=100){
         $api_text = 'Moderate';
     

     
     }else if($api >=101 && $api<=150){
         $api_text = 'Unhealthy for Sensitive Groups';
;

     }else if($api >=151 && $api<=200){
         $api_text = 'Unhealthy';


     }else if($api >=201 && $api<=300){
         $api_text = 'Very Unhealthy';


     }else if($api >=301 && $api<=400){
         $api_text = 'Hazardou';

     }
        
        
        
        

       $ex= (object) [
                'success'   => true,
                'msg'   => $api_text,
                'data'=> $api,
                
            ];
    
    return response()->json($ex);    }
    
    
    
    
    
    public function api(Request $request)
    {
        $api = Mobile::get();
          return response()->json([
            'success' => true,
            'msg'     => '',
            'data'    => $api
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroysallary(int $id)
    {

        $WorkerSallary = WorkerSallary::where('id', $id);

        $WorkerSallary->delete();

        return response()->json([
            'success' => true,
            'msg'     => '',
            'data'    => $WorkerSallary
        ]);

    }
}
