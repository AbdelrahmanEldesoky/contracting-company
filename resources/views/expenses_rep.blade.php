<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>تقرير عامل</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
</head>
<body >
<div class="wrapper" >
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header">
          <h2 class="page-header">
            <img style="height: 50px;" src="{{ asset('logo.jpg')}}"></i> بحر
            <small class="float-right">تاريخ: {{$date_ym}}</small>
          </h2>
       
        <h2 class="page-header" style="text-align:center;">
           تقرير مصاريف عن مشروع ({{$project}})}
        </h2>
      </div>
      <!-- /.col -->
    </div>

    <div style="margin-top: 50px;   margin-bottom: 20px;">  
 <h5 style="text-align: right;">تقرير مفصل بمصاريف المشروع و المعدات الادوات</h5>
    </div>

    <!-- Table row -->
    <div class="row" dir="rtl">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>#</th>
            <th>تاريخ</th>
            <th>اسم المصروف</th>
            <th>البيان</th>
            <th>السعر</th>
          </tr>
          </thead>
          <tbody>
            @isset($expenses)
            @foreach ($expenses as $index=>$acc)
          <tr>
            <td>{{$index+1}}</td>
            <td>{{$acc->date_expenses}}</td>
            <td>{{$acc->name}}</td>
            <td>{{$acc->statement}}</td>
            <td>{{$acc->sallary}}</td>
          </tr>
            @endforeach
            @endisset
          </tbody>
           <tbody>
      
          <tr style="font-size: x-large;">
            <td></td>
            <td>الاجمالي</td>
            <td>{{$total}}</td>
            <td></td>
            <td></td>
           
          </tr> 
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
  <footer  style="margin-top: 1050px" class="main-footer">
          <strong style="text-align: left; width:50%; display: inline-block; font:bold;">شركة بحر</strong>
          <p style="text-align: right; width:49%;  display: inline-block;">رقم الاردارة : 0599690962</p>
    </footer>
</html>
