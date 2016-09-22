
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
                    <h2>User Profile <small>Activity report</small></h2>
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
                          <img class="img-responsive avatar-view" src=" {{ '/img/'.Auth::user()->pic }}" alt="Avatar" title="Change the avatar">

                          <!-- Cropping modal -->
                          <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                <form class="avatar-form" action="crop.php" enctype="multipart/form-data" method="post">
                                  <div class="modal-header">
                                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                                    <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="avatar-body">

                                      <!-- Upload image and data -->
                                      <div class="avatar-upload">
                                        <input class="avatar-src" name="avatar_src" type="hidden">
                                        <input class="avatar-data" name="avatar_data" type="hidden">
                                        <label for="avatarInput">Local upload</label>
                                        <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                                      </div>

                                      <!-- Crop and preview -->
                                      <div class="row">
                                        <div class="col-md-9">
                                          <div class="avatar-wrapper"></div>
                                        </div>
                                        <div class="col-md-3">
                                          <div class="avatar-preview preview-lg"></div>
                                          <div class="avatar-preview preview-md"></div>
                                          <div class="avatar-preview preview-sm"></div>
                                        </div>
                                      </div>

                                      <div class="row avatar-btns">
                                        <div class="col-md-9">
                                          <div class="btn-group">
                                            <button class="btn btn-primary" data-method="rotate" data-option="-90" type="button" title="Rotate -90 degrees">Rotate Left</button>
                                            <button class="btn btn-primary" data-method="rotate" data-option="-15" type="button">-15deg</button>
                                            <button class="btn btn-primary" data-method="rotate" data-option="-30" type="button">-30deg</button>
                                            <button class="btn btn-primary" data-method="rotate" data-option="-45" type="button">-45deg</button>
                                          </div>
                                          <div class="btn-group">
                                            <button class="btn btn-primary" data-method="rotate" data-option="90" type="button" title="Rotate 90 degrees">Rotate Right</button>
                                            <button class="btn btn-primary" data-method="rotate" data-option="15" type="button">15deg</button>
                                            <button class="btn btn-primary" data-method="rotate" data-option="30" type="button">30deg</button>
                                            <button class="btn btn-primary" data-method="rotate" data-option="45" type="button">45deg</button>
                                          </div>
                                        </div>
                                        <div class="col-md-3">
                                          <button class="btn btn-primary btn-block avatar-save" type="submit">Done</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                                    <button class="btn btn-default" data-dismiss="modal" type="button">Close</button>
                                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                          <!-- /.modal -->

                          <!-- Loading state -->
                          <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                        </div>
                        <!-- end of image cropping -->
					
						<form method="post" action="{{url('/pic-proc')}}" class="img-responsive avatar-view" enctype="multipart/form-data">
		
							{{csrf_field()}}
							<div>
								@if(Session::has('message'))
									<span> {{ Session::get('message')}} </span>
								@endif
							</div>
                        
							<input type="hidden" name="id" value="{{Auth::user()->id}}">
							<input type="file" name="pic" class="form-control"/>
							<p></p>
							<input type="submit" value="Change" class="btn btn-success"/>
						</form>
						
                    </div>
                    
                      <h3>{{Auth::user()->username}}</h3>

                      <ul class="list-unstyled user_data">
                      	<li><i class="fa fa-map-marker user-profile-icon"></i> Indonesia
                        </li>

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> {{Auth::user()->email}}
                        </li>
                      </ul>

                      <a href="pic-user" class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>change profile photo</a>
                      <br />

                      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> -->
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