<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

        {{-- icon font --}}
        <link rel="stylesheet" href="{{asset('icofont/icofont.min.css')}}">

        <!-- Google Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">

        <!-- Bootstrap core CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

        <!-- Material Design Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

          <!-- Datable -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">


         <!-- DateRangePicker -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <link rel="stylesheet" href="{{asset('css/style.css')}}">

        {{-- select2 --}}
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        {{--  ViewerJs    --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.2/viewer.min.css">

        <link rel="stylesheet" href="{{asset('css/material.theme.css')}}">
        @yield('extra_css')
</head>
<body>
<div class="page-wrapper chiller-theme ">

  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">HR AdminDashBorad</a>
        <div id="close-sidebar">
          <i class="fas fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-pic">
          <img class="img-responsive img-rounded" src="{{auth()->user()->img_path()}}"
            alt="User picture">
        </div>
        <div class="user-info">
          <strong class="user-name">{{Auth::user()->name}}

          </strong>
          <span class="user-role">Administrator</span>
          <span class="user-status">
            <i class="fa fa-circle"></i>
            <span>Online</span>
          </span>
        </div>
      </div>
      <!-- sidebar-header  -->
      <div class="sidebar-search">
        <div>
          <div class="input-group">
            <input type="text" class="form-control search-menu" onkeyup="myFunction()" id="myInput" placeholder="Search...">
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="fa fa-search" aria-hidden="true"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <!-- sidebar-search  -->
      <div class="sidebar-menu">
        <ul id="myUL">
          <li class="header-menu">
            <span>General</span>
          </li>
          <li>
            <a href="{{route('home')}}">
              <i class="fas fa-home"></i>
              <span>Home</span>
            </a>
          </li>
{{--          @can('view_employee')--}}
          <li>
            <a href="{{route('employee.index')}}">
              <i class="fas fa-users"></i>
              <span>Employee</span>
            </a>
          </li>
{{--          @endcan--}}
          @can('view_company_setting')
          <li>
            <a href="{{route('companysetting.show',1)}}">
                <i class="fas fa-building"></i>
              <span>Company Rule</span>
            </a>
          </li>
          @endcan
          @can('view_department')
          <li>
            <a href="{{route('department.index')}}">
              <i class="fas fa-users"></i>
              <span>Department</span>
            </a>
          </li>
           @endcan
{{--          @can('view_role')--}}
          <li>
            <a href="{{route('role.index')}}">
                <i class="fas fa-shield-alt"></i>
              <span>Role</span>
            </a>
          </li>
{{--          @endcan--}}
{{--          @can('view_permission')--}}
          <li>
            <a href="{{route('permission.index')}}">
                <i class="fas fa-user-shield"></i>
              <span>Permisssion</span>
            </a>
          </li>
{{--            @endcan--}}
            @can('view_attendance')
          <li>
            <a href="{{route('attendance.index')}}">
                <i class="fas fa-sticky-note"></i>
              <span>Attendance</span>
            </a>
          </li>
            @endcan
            @can('view_attendance')
                <li>
                    <a href="{{route('attendance-overview')}}">
                        <i class="fas fa-sticky-note"></i>
                        <span>Attendance(Over View)</span>
                    </a>
                </li>
            @endcan
            @can('view_salary')
                <li>
                    <a href="{{route('salary.index')}}">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Salary</span>
                    </a>
                </li>
            @endcan
            @can('view_salary')
                <li>
                    <a href="{{route('payroll-overview')}}">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Salary OverView</span>
                    </a>
                </li>
            @endcan
           @can('view_project')
                <li>
                    <a href="{{route('project.index')}}">
                        <i class="fas fa-money-check-alt"></i>
                        <span>Project</span>
                    </a>
                </li>
            @endcan
          {{-- <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-globe"></i>
              <span>Maps</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Google maps</a>
                </li>
                <li>
                  <a href="#">Open street map</a>
                </li>
              </ul>
            </div>
          </li> --}}

        </ul>
      </div>
      <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->

  </nav>
        <div class="app-nav ">
                <div class="d-flex justify-content-center align-content-center">
                    <div class="col-md-8">
                       <div class="d-flex justify-content-between">
                       @if (request()->is('/'))
                       <a id="show-sidebar" class=""  href="#">
                        <i class="fas fa-bars "></i>
                       </a>
                        @else
                        <a id="back-btn" class="" style="font-size: 23px"  href="#">
                            <i class="fas fa-arrow-left"></i>
                      </a>
                       @endif
                           <h4 class="text-secondary font-weight-bolder mb-0 mt-1">@yield('title')</h4>
                           <a href=""></a>
                       </div>
                    </div>
                </div>
          </div>

            <div class="py-4 content">
                <div class="d-flex justify-content-center index-table ">
                    <div class="col-md-12 col-lg-10 ">
                        @yield('content')
                    </div>
                </div>
            </div>

        <div class="bottom-bar">
            <div class="d-flex justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-between">
                        <a href="{{route('home')}}">
                            <i class="icofont-home"></i>
                         <p class="mb-0">Home</p>
                        </a>

                        <a href="{{route('attendanceScan')}}">
                            <i class="fas fa-user-cog"></i>
                         <p class="mb-0">Attendance</p>
                        </a>

                        <a href="{{route('my-project.index')}}">
                            <i class="icofont-presentation-alt"></i>
                         <p class="mb-0">Project</p>
                        </a>

                        <a href="{{route('profile')}}">
                            <i class="icofont-user-alt-4"></i>
                         <p class="mb-0">Profile</p>
                        </a>
          </div>
                    </div>
                </div>
            </div>
        </div>

</div>


    <!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>

<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

<!-- Datable -->
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.13/features/mark.js/datatables.mark.js"></script>
<script src="https://cdn.jsdelivr.net/g/mark.js(jquery.mark.min.js)"></script>

<!-- DatePicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

 <!-- Laravel Javascript Validation -->
 <script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

 <!-- sweetalert2 -->
 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- sweeslert --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

{{-- Select 2 --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Larapass  --}}
<script src="{{ asset('vendor/larapass/js/larapass.js') }}"></script>

{{--Viewer Js--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.2/viewer.min.js"></script>

<!-- jsDelivr :: Sortable -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    $(function ($) {

                let token =document.head.querySelector('meta[name="csrf-token"]');
                if(token){
                    $.ajaxSetup({
                            headers:{
                                'X-CSRF-TOKEN':token.content
                            }
                });

                }else{
                    console.error('Token Not Found');
                }
              $(".sidebar-dropdown > a").click(function() {
            $(".sidebar-submenu").slideUp(200);
            if (
              $(this)
                .parent()
                .hasClass("active")
            ) {
              $(".sidebar-dropdown").removeClass("active");
              $(this)
                .parent()
                .removeClass("active");
            } else {
              $(".sidebar-dropdown").removeClass("active");
              $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
              $(this)
                .parent()
                .addClass("active");
            }
              });

            $("#close-sidebar").click(function(e) {
              e.preventDefault();
                 $(".page-wrapper").removeClass("toggled");
            });
            $("#show-sidebar").click(function(e) {
              e.preventDefault();
              $(".page-wrapper").addClass("toggled");
            });

            @if (request()->is('/'))
            document.addEventListener('click',function (e){
                if(document.getElementById('show-sidebar').contains(e.target)){
                    $(".page-wrapper").addClass("toggled");
                }
                else if(!document.getElementById('sidebar').contains(e.target)){
                    $(".page-wrapper").removeClass("toggled");
                }
            } );
            @else
            @endif
            $.extend(true, $.fn.dataTable.defaults, {
                    mark: true,
                    language: {
            "paginate": {
                "next": "<i class='fas fa-arrow-circle-right'></i>",
                "previous": "<i class='fas fa-arrow-circle-left'></i>"
                },
                "processing": "<img src='/image/loading.gif'><p>Loading...</p>",
        }

                });
                $('#back-btn').on('click',function (e){
                    e.preventDefault();
                    window.history.go(-1);
                    return false;
                });
                $('.custom-select').select2({
                    placeholder:'--Select Employee--',

                });
});
    function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("span")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
</script>
@yield('script')
</body>
</html>
