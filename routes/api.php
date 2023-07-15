<?php

use App\Http\Controllers\API\Admin\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;


Route::group(['middleware'=>['api'/*,'checkPassword'*/]], function (){
   Route::get('clear',function(){
        Artisan::call('route:cache');
        Artisan::call('route:clear');
        Artisan::call('optimize');
        return 'done';
   }); 
   Route::post('worker', 'WorkerController@store');
   Route::post('m','WorkerSallaryController@m');
   Route::post('control','WorkerSallaryController@control');
   Route::post('espso','WorkerSallaryController@espso');
   Route::get('nesba','WorkerSallaryController@nesba');
   Route::get('espnow','WorkerSallaryController@espnow');
   Route::get('espt','WorkerSallaryController@espt');
   Route::get('espall','WorkerSallaryController@espall');
   Route::get('moasher','WorkerSallaryController@moasher');
//############################# Star report ###########################################
   Route::get('summary_rep/{user_id}/{project_id}','ProjectController@summary_rep');
   Route::get('workers_rep/{project_id}/{date_id}','WorkerAccountController@workers_rep');
   Route::get('worker_rep/{project_id}/{date_id}/{worker_id}','WorkerAccountController@worker_rep');
   Route::get('ex_rep/{date_id}/{project_id}','ExpensesController@expenses_rep');

   Route::get('worker_month_name_rep/{date}/{user_id}','WorkerAccountController@worker_month_name_rep');
   Route::get('worker_month_rep/{date}/{woker_id}/{user_id}','WorkerAccountController@worker_month_rep');
//############################# End report ###########################################
   
    Route::post('esp32','WorkerSallaryController@esp32');
    Route::post('esp_post_mob','WorkerSallaryController@esp_post_mob');
    Route::get('esp32_get_mob','WorkerSallaryController@esp23_get_mob');
   
   Route::post('res','WorkerSallaryController@d4000');
    Route::get('mobile','WorkerSallaryController@api');
    Route::get('workergeneratepdf/{project_id}', 'PdfController@workergeneratePdf');
    Route::get('workerdownloadpdf/{project_id}', 'PdfController@workerdownloadPdf');
    Route::post('login','AuthController@login');
    Route::get('profile','AuthController@profile');
    Route::post('logout','AuthController@logout');
    Route::post('register','AuthController@register')->middleware(['auth.guard:admin-api']);;
    Route::post('updateuser/{id}','AuthController@updateuser')->middleware(['auth.guard:admin-api']);;
    Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('logout','AuthController@logout') -> middleware(['auth.guard:admin-api']);
    });
});

Route::group(['middleware'=>['auth:api'/*,'checkPassword'*/]], function (){
    ############################ Home Route #################################################
    Route::get('profile', 'HomeController@profile');
    Route::get('home', 'HomeController@home');
    
    ################################ Worker Route ###############################################
    Route::resource('worker', 'WorkerController')->except(['show','edit','create','get','store']);
    Route::get('workerproject/{project_id}', 'WorkerController@get');
    Route::get('allworker', 'WorkerController@allworker');
    Route::get('projectnull', 'WorkerController@projectnull');
    Route::post('storeRegister','WorkerController@storeRegister');
    ################################ Project Route ###############################################
    Route::resource('project', 'ProjectController')->except(['show','edit','create','alluser']);
    Route::get('project/get', 'ProjectController@get');
    Route::get('project/nesba', 'ProjectController@nesbaa');
    Route::get('test','ProjectController@test');
    ################################ Sallary Route ###############################################
    Route::get('sallary/{project_id}/{date}', 'WorkerSallaryController@get');
    Route::post('sallarydaily/{id}', 'WorkerSallaryController@sallarydaily');
    Route::get('sallarydailydetails/{id}', 'WorkerSallaryController@sallarydailydetails');  
    Route::post('deletesallary/{id}', 'WorkerSallaryController@destroysallary');
    ################################ Expenses Route ##############################################
    Route::get('monthlyexpenses/{project_id}', 'ExpensesController@get');
    Route::post('monthlyexpenses/store/{project_id}', 'ExpensesController@storeExpenses');
    Route::post('monthlyexpenses/update/{id}', 'ExpensesController@updateExpenses');
    Route::post('monthlyexpenses/delete/{id}', 'ExpensesController@deleteExpenses');
    Route::get('monthlyexpenses/report/{date}/{project_id}', 'ExpensesController@report');
    ################################ Payment Route ################################################
    Route::get('payments/get/{project}/{worker_id}','PaymentsController@getPayments');
    Route::post('payments/store/{project}','PaymentsController@storePayments');
    Route::post('payments/update/{id}','PaymentsController@updatePayments');
    Route::post('payments/delete/{id}','PaymentsController@deletePayments');
    ################################ Worker account statement ##################################
    Route::get('workersaccount/{project_id}/{date}','WorkerAccountController@workers');
    Route::get('worker_month_name/{date}','WorkerAccountController@worker_month_name');
    Route::get('worker_month/{date}/{woker_id}','WorkerAccountController@worker_month');
    Route::get('workeraccount/{project_id}/{date}/{worker_id}','WorkerAccountController@worker');
    Route::get('projectsummary/{project_id}','ProjectController@summary');
    Route::get('summarydetails/{project_id}','ProjectController@summarydetails');
    Route::post('end_project/{id}','ProjectController@end');
    
    ################################# NOTE ROUTE ###########################################
    Route::resource('note', 'NoteController')->except(['show','edit','create']);
    ################################## Route BUDGET ############################################
    Route::post('budgetStore/{project_id}','Admin\ProjectBudgetController@store');
    Route::get('budget/{project_id}','Admin\ProjectBudgetController@get');
    Route::post('budget/{id}','Admin\ProjectBudgetController@update');
    Route::post('budgetdelete/{id}','Admin\ProjectBudgetController@delete');
    ############################## SEGAL ROUTE #######################################
    Route::resource('segal', 'SegalController')->except(['show','edit','create']);
    Route::get('segal/{project_id}/{date}/{segal_id}', 'WorkerSegalController@get');
    Route::post('segaldaily/{id}', 'WorkerSegalController@sallarydaily');
    Route::get('segaldailydetails/{id}', 'WorkerSegalController@sallarydailydetails');
    Route::get('segalreport/{project_id}/{segal_id}/{date}', 'WorkerSegalController@reprotall');
    Route::get('segalreportone/{project_id}/{segal_id}/{date}/{worker_id}', 'WorkerSegalController@reprotone');
     ############################# Order ROUTE ######################################
     Route::resource('order', 'OrderController'); 
      
});

Route::group(['middleware'=>['auth.guard:admin-api'/*,'checkPassword'*/],'prefix' => 'admin','namespace'=>'Admin'],function (){

    Route::get('alluser', 'UsersController@alluser');
    Route::post('deleteuser/{id}','UsersController@deleteuser');
    Route::resource('workeradmin','WorkeradminController');
    Route::get('projectunderway','ProjectController@underway');
    Route::get('projectfinshed','ProjectController@finshed');
    Route::get('projectsummary/{project_id}','ProjectController@summary');
});

Route::group(['middleware'=>['auth.guard:worker-api'/*,'checkPassword'*/],'prefix' => 'worker','namespace'=>'Worker'],function (){
    Route::post('change', 'AccountController@change');
    Route::get('os','OrderwController@order');
    Route::post('o/{id}','OrderwController@postorder');
    Route::post('d/{id}','OrderwController@delteorder');
    //--------------
    Route::get('user_worker','OrderwController@user_worker');
    Route::get('delete_relation','OrderwController@delete_relation');
    //------------------
    Route::get('profile', 'AccountController@profile');
    Route::get('/{date}', 'AccountController@account');
    Route::get('sallary/{date}', 'WorkerSallaryController@get');
    Route::post('sallarydaily/{id}', 'WorkerSallaryController@sallarydaily');
    Route::get('sallarydailydetails/{id}', 'WorkerSallaryController@sallarydailydetails');
 
    Route::get('segal/{date}/{segal_id}', 'WorkerSegalController@get');
    Route::post('segaldaily/{id}', 'WorkerSegalController@sallarydaily');    
});























