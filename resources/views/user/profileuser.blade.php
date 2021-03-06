
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
            
            @include('user/sidebar')

          </div>
        </div>


        @include('user/topmenu')


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>User Profile</h3>
              </div>

            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Report <small>Activity report</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">

                      <div class="profile_img">

                        <!-- end of image cropping -->
                        <div id="crop-avatar">
                          <!-- Current avatar -->
                          	<?php
			              		if(empty(Auth::user()->pic)){
			              			$foto = asset("img/avatar.png");
			              		} else {
			              			$foto = '/img/'.Auth::user()->pic ;
			              		}
							?>
                          <img class="img-responsive avatar-view" src=" {{ $foto }}" alt="Avatar" title="Change the avatar">

                          
                      <h3>{{Auth::user()->username}}</h3>

                      <ul class="list-unstyled user_data">
                      	<li><i class="fa fa-map-marker user-profile-icon"></i> Indonesia
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> {{Auth::user()->email}}
                        </li>
                     </ul>

                      <a href="{{URL('pic-user')}}" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>change profile photo</a>
                      <a href="{{URL('change-password')}}" class="btn btn-success">Change Password</a>
                      <br />
                      

                    </div>
                    
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        @include('gentelella/footer')
        
      </div>
    </div>

    @include('gentelella/footerjs')
    
    <!-- bootstrap-progressbar -->
    <script src="{{ asset("assets/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js") }}"></script>
    
    <script src="{{ asset("assets/gentelella/build/js/custom.min.js") }}" ></script>

  </body>
</html>