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

<meta name="csrf-token" content="{{ csrf_token() }}">



</head>

<body class="">

<h4>Studey Source Link</h4>
<a target="_blank" href="https://shareurcodes.com/blog/laravel%20datatables%20server%20side%20processing">
    Laravel Datatable Server Side Render
</a>
<br>

<a target="_blank" href="https://www.codexworld.com/datatables-server-side-processing-custom-search-filter-with-php-mysql/">
    Laravel Datatable Server Side Render & Custome Searc
</a>

<div class="container">
    <div class="row">
        <div class="post-search-panel">
    <input type="text" id="searchInput" placeholder="Type keywords..." />
    <select id="sortBy">
        <option value="">Sort by</option>
        <option value="1">Active</option>
        <option value="2">Inactive</option>
    </select>
</div>
    </div>
</div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered common_table" data-source="{{url('/category/data')}}">
                    <thead>
                        <th>+</th>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Time</th>

                       
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

       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.created_at+'</td>'+
            '</tr>'+
        '<tr>'+
            '</table>';
    }








      var table =  $('.common_table').DataTable({

            "searching": false,
            "processing": true,
            
            "serverSide": true,
            "ajax":{
                     "url": source_data,
                     "dataType": "json",
                     "type": "POST",
                     "data": function ( d ) {
                        return $.extend( {}, d, {
                        "search_keywords": $("#searchInput").val().toLowerCase(),
                        "filter_option": $("#sortBy").val().toLowerCase()
                        } );
                    }
                     
                   },
            "columns": [
               {
                
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": '',
                "searchable": false,
                "orderable":false,
                
                },
                { "data": "sl", "searchable": false,"orderable":false},
                { "data": "name"  },
                { "data": "created_at" },
                { "data": "status","orderable":false },
        
                { "data": "options","searchable": false,"orderable":false }
            ],
          
            "order": [[ 2, "asc" ]]	,
        //    "stateSave": true,
        dom: 'Bfrtip',
         "buttons": [
        'copy', 'excel', 'pdf'
            ]

        });




    


$(document).ready(function() {
     table.draw();
    
    // Redraw the table based on the custom input
    $('#searchInput,#sortBy').bind("input", function(){
        table.draw();
    });
} );







        $('.common_table tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );










    });













    
    </script>










</body>

</html>