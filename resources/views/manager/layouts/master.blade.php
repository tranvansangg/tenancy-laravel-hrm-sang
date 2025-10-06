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
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i>Đăng
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
                    <a href="{{route('manager.dashboard')}}"><span class=""><i class="fa fa-dashboard fa-fw"></i> Dashboard </span></a>

    
                </li>
                <li>
                    <a href="#"><i class="fa fa-users fa-fw"></i> Nhân Viên<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.employees.index')}}">Danh Sách Nhân Viên phòng</a>
                        </li>
                    
                   

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
               @php
    $user = Auth::user();
    $isKeToanManager = $user && $user->employee && $user->employee->position && 
                       $user->employee->position->name === 'Trưởng phòng' && 
                       $user->employee->department->name === 'Phòng Kế Toán';
@endphp

@if($isKeToanManager)
<li>
    <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Quản Lý Lương<span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        <li>
            <a href="{{route('manager.payrolls.indexx')}}">Tính Lương</a>
        </li>
 
    </ul>
</li>
@endif

                <li>
                    <a href="#"><i class="fa-solid fa-briefcase"></i> Quản Lý Công Tác<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.business_trips.create')}}">Tạo Công Tác</a>
                        </li>
                        <li>
                            <a href="{{route('manager.business_trips.index')}}">Danh Sách Công Tác</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-user-group"></i>
                        Nhóm Nhân Viên<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                      
                        <li>
                            <a href="{{route('manager.groups.index')}}">Danh Sách Nhóm</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>OT<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.overtimes.create')}}">Tạo OT</a>
                        </li>
                        <li>
                            <a href="{{route('manager.overtimes.index')}}">Danh Sách OT</a>
                        </li>

                    </ul>
                    <!-- /.nav-second-level -->
                <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>Nghỉ phép<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.leaves.create')}}">Nghị phép</a>
                        </li>
                        <li>
                            <a href="{{route('manager.leaves.index')}}">Danh Sách Nghị phép nhân viên</a>
                        </li>
                        <li>
                            <a href="{{route('manager.leaves.my_leaves')}}">Danh Sách Nghỉ phép của tôi</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-user"></i> Tài Khoản<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.account.edit')}}">Thông Tin Tài Khoản</a>
                        </li>
                     
                        <li>
                            <a href="{{route('manager.account.change-password')}}">Đổi Mật Khẩu</a>
                        </li>
                   

                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>HolidayRequest<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.holiday_requests.create')}}">HolidayRequest</a>
                        </li>
                        <li>
                            <a href="{{route('manager.holiday_requests.index')}}">Danh Sách HolidayRequest</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>Bảo Hiểm Xã hội<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.insurance.my')}}">Bảo Hiểm Xã hội của tôi</a>
                        </li>
                        <li>
                            <a href="{{route('manager.insurance.index')}}">Danh Sách Bảo Hiểm Xã hội</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa-solid fa-scale-balanced"></i>Lương của tôi<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{route('manager.payrolls.mypayroll')}}">Lương của tôi</a>
                        </li>
                       
                    </ul>
                    <!-- /.nav-second-level -->
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>