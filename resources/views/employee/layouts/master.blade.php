<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.html">Admin Area - SangTran</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <!-- /.dropdown -->
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                            class="fa fa-sign-out fa-fw"></i>Đăng
                        xuất</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf
                    </form>
                    </a>
                </li>
            </ul>

            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard </span></a>

        
      
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Quản Lý Lương<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                    
                        <li>
                            <a href="{{ route('employee.payrolls.index') }}">Bảng Lương của tôi</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-plane fa-fw"></i> Công Tác<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
               
                        <li>
                            <a href="{{ route('employee.business_trips.index')}}">Danh Sách Công Tác của tôi</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-user-group"></i>
                        Nhóm Nhân Viên<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{ route('employee.groups.index') }}">Danh Sách Nhóm</a>
                        </li>
                      

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
     

              
                    <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>Nghỉ phép<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
<a href="{{ route('employee.leaves.create') }}">Tạo đơn nghỉ phép</a> 
                        </li>
                        <li>
<a href="{{ route('employee.leaves.index') }}">Danh sách nghỉ phép của tôi</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                  <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>

                       Liên hệ<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">danh sách liên hệ</a>
                        </li>
                       
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-user"></i> Tài Khoản<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ route('employee.account.edit')}}">Thông Tin Tài Khoản</a>
                        </li>
                   
                        <li>
                            <a href="{{ route('employee.account.change-password')}}">Đổi Mật Khẩu</a>
                        </li>
                       

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
          
                <li>
                    <a href="#"><i class="fa-solid fa-gears"></i>OT<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{ route('employee.overtimes.index')}}">danh sách OT của tôi</a>
                        </li>
                        
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-gears"></i>Holiday Request<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{route('employee.holiday_requests.index')}}">danh sách holiday request</a>
                        </li>
                        <li>
                            <a href="{{route('employee.holiday_requests.create')}}">tao holiday request</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-gears"></i>Bảo Hiểm Xã hội<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{route('employee.insurance.index')}}">danh sách bao hiem của toi</a>
                        </li>
                      
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
               
       

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>