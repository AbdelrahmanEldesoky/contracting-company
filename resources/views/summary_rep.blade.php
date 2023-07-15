<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>تقرير المشروع</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
</head>
<body dir="rtl">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h2 class="page-header" style="text-align:center;">
             <img style="height: 50px;" src="{{ asset('logo.jpg')}}"></i> بحر
        
        </h2>
        
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div >
      <div  style="text-align:right;">
        <strong>مشرف : {{$pr->user}}</strong><br>
          <strong  style="font-size: large;"> 
            تم بدء مشروع : {{$pr->project_name}}
            
          <br> 
          في تاريخ : {{$pr->project_date}}<br>
          بمزانية : {{$pr->project_sallary}} شكيل<br>
        </strong>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

  

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-12" style="text-align:right;">
        <p class="lead">تقرير حساب المشروع:</p>

        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
         بعد الاطلاع وجمع ميزانية المشروع ودفع رواتب العمال و دفع مصروفات المادة نأتي بهذا التقرير :
        </p>
      </div>
      <div class="row">
      <!-- /.col -->
      <div >

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:70%">ميزانية المشروع : </th>
              <td>{{$pr->budgets}} شيكل</td>
            </tr>
            <tr>
              <th>اجمالي مصاريف العمال : </th>
              <td>{{$pr->payments}} شيكل</td>
            </tr>
            <tr>
              <th>اجمالي المصروفات : </th>
              <td>{{$pr->expenses}} شيكل</td>
            </tr>
            <tr>
              <th>اجمالي : </th>
              <td>{{$pr->total}} شيكل</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
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
  <footer  style="position: absolute;
  bottom: 0;" class="main-footer">
          <strong style="text-align: left;  display: inline-block; font:bold;">شركة بحر</strong>
          <p style="text-align: right;   display: inline-block;">رقم الاردارة : 0599690962</p>
    </footer>
</html>
