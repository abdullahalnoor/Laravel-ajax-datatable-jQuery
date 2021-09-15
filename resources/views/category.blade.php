<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
            <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">
            <link rel="stylesheet" href="{{asset('admin/css/datatables.min.css')}}">
            <link rel="stylesheet" href="{{asset('admin/css/responsive.bootstrap4.min.css')}}">
            <link rel="stylesheet" href="{{asset('admin/css/responsive.dataTables.min.css')}}">

            {{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/> --}}

     
    </head>
    <body class="">
     

        <div class="container mt-5">
             <div class="row">
	<div class="col-md-12">
               <table class="table table-bordered common_table"  data-source="{{url('/category/data')}}">
                    <thead>
                           <th>Id</th>
                           <th>Title</th>
                           
                           <th>Created At</th>
                           <th>Options</th>
                    </thead>				
               </table>
        </div>
</div>
        </div>









<script src="{{asset('admin/js/jquery-3.6.0.min.js')}}"></script>
- <script src="{{asset('admin/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin/js/datatables.min.js')}}"></script>
<script src="{{asset('admin/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/js/responsive.bootstrap4.min.js')}}"></script>

{{-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script> --}}

<script>
var source_data  = $('.common_table').data('source');
   $(document).ready(function () {
        $('.common_table').DataTable({
            "processing": true,
            
            "serverSide": true,
            "ajax":{
                     "url": source_data,
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "created_at" },
                { "data": "options" }
            ]	 

        });
    });
</script>










    </body>
</html>
