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
                    <a href="#"><i class="fa fa-dashboard fa-fw"></i> Dashboard <span class="fa arrow"></span></a>

                    <ul class="nav nav-second-level">
                        <li>
                            <a href="#">Thống Kê</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.employees.index')}}">Danh Sách Nhân Viên</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index')}}">Danh Sách Tài Khoản</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users fa-fw"></i> Nhân Viên<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ route('admin.departments.index') }}">Phòng Ban</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.positions.index') }}">Chức Vụ</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.education_levels.index') }}">Trình độ</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.specialties.index') }}">Chuyên môn</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.degrees.index') }}">Bằng Cấp</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.employee_types.index') }}">Loại Nhân Viên</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.employees.create') }}">Thêm Nhân Viên Mới</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.employees.index') }}">Danh Sách Nhân Viên</a>
                        </li>

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Quản Lý Lương<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                       
                        <li>
                            <a href="{{ route('admin.payrolls.index')}}">Bảng Tính Lương toàn công ty</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-briefcase"></i> Quản Lý Công Tác<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                    
                        <li>
                            <a href="{{route('admin.business_trips.index')}}">Danh Sách Công Tác</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-user-group"></i>
                        Nhóm Nhân Viên<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('admin.groups.create')}}">Tạo Nhóm</a>
                        </li>
                        <li>
                            <a href="{{route('admin.groups.index')}}">Danh Sách Nhóm</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                   <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>

                        Khen Thưởng - Kỷ Luật<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('admin.bonuses.index')}}">khen thuơng</a>
                        </li>
                        <li>
                            <a href="{{route('admin.deductions.index')}}">kỷ luật</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

              
                    <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>Tuyển Dụng<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ route('admin.jobs.index')}}">Quản lý việc làm </a>
                        </li>
                        <li>
                            <a href="{{route('admin.applications.index')}}">Quản lý ứng viên</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                  <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>

                       Liên hệ<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ route('admin.contacts.index')}}">danh sách liên hệ</a>
                        </li>
                       
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-user"></i> Tài Khoản<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ route('admin.account.edit')}}">Thông Tin Tài Khoản</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.create') }}">Tạo Tài Khoản</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users.index') }}">Danh Sách Tài Khoản</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.account.change-password')}}">Đổi Mật Khẩu</a>
                        </li>
                    

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-gears"></i>Bảo hiểm - phụ cấp<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{route('admin.allowances.index')}}">danh sách phụ cấp</a>
                        </li>
                   
                    
                    
                         <li>
                            <a href="{{route('admin.insurances_records.index')}}">danh sách bảo hiểm</a>
                        </li>
                    
                     
                     

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-gears"></i>OT<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{route('admin.overtimes.index')}}">danh sách OT</a>
                        </li>

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-gears"></i>Holiday<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{route('admin.holidays.index')}}">danh sách Holiday</a>
                        </li>

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-gears"></i>Holiday Request<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{route('admin.holiday_requests.index')}}">danh sách Holiday Request</a>
                        </li>

                    </ul>
                    <!-- /.nav-second-level -->

                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-gears"></i>Leave Request<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                
                        <li>
                            <a href="{{route('admin.leaves.index')}}">danh sách Leave Request</a>
                        </li>
               
       

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>