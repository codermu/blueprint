            <div class="navbar nav_title" style="border: 0;">
              <h3 class="site_title"> Indosystem CMS </h3>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
              	<?php
              	if(empty(Auth::user()->pic)){
              		$foto = asset("img/avatar.png");
              	} else {
              		$foto = '/img/'.Auth::user()->pic ;
              	}
				?>
				<img src="{{$foto}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome</span>
                
                <h2>{{Auth::user()->username}}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i>Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{{ URL('logout')}}">Out</a></li>
                    </ul>
                  </li>
               </ul>
             </div>
            </div>
            <!-- /sidebar menu -->