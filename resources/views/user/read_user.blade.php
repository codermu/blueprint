
<!DOCTYPE html>
<html lang="en">
  <head>
    
    @include('headermeta')
    
    <!-- Datatables -->
    <link href="{{ asset("assets/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css") }}"  rel="stylesheet">
    <link href="{{ asset("assets/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css") }}"  rel="stylesheet">
    <link href="{{ asset("assets/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css") }}"  rel="stylesheet">
    <link href="{{ asset("assets/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css") }}"  rel="stylesheet">
    <link href="{{ asset("assets/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css") }}"  rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ asset("assets/gentelella/build/css/custom.min.css") }}"  rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            
            @include('/user/sidebar')

          </div>
        </div>


        @include('/user/topmenu')


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Users <small>Some examples to get you started</small></h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2> List Siswa </h2>
                    
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link">&nbsp;</a></li>
                      <li><a class="collapse-link">&nbsp;</a></li>
                      <li><a class="collapse-link">&nbsp;</a></li>
                      <li><a class="collapse-link">&nbsp;</a></li>
                      <li><a class="collapse-link">&nbsp;</a></li>
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction function: <code>$().DataTable();</code>
                    </p>
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          	<th> No </th>
				  			<th> ID </th>
				  			<th> Name </th>
				  			<th> Alamat</th>
				  			<th> Kelas </th>
				  		</tr>
         			</thead>
         			<?php $ni=1; ?>
	  				@foreach($siswa as $data2)
	  				<tr>
				      	<td>{{$ni++}}</td>
				      	<td>{{$data2 -> id}}</td>
				  		<td>{{$data2-> nama}}</td>
			     		<td>{{$data2 -> alamat}}</td>
			     		<td>{{$data2 -> kelas}}</td>
			      	</tr>
				  	
				  	@endforeach
                      <!-- /page content -->
        
        @include('footer')
        
      </div>
    </div>

    @include('footerjs')
    
    <!-- Datatables -->
    <script src="{{ asset("assets/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/datatables.net-scroller/js/datatables.scroller.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/jszip/dist/jszip.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/pdfmake/build/pdfmake.min.js") }}" ></script>
    <script src="{{ asset("assets/gentelella/vendors/pdfmake/build/vfs_fonts.js") }}" ></script>

    <!-- Custom Theme Scripts -->
    <script src="{{ asset("assets/gentelella/build/js/custom.min.js") }}" ></script>

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->
  </body>
</html>