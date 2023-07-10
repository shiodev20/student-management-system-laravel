<nav class="sidebar sidebar-offcanvas" id="sidebar">

  @switch($currentUser['role'])
    @case(1)
      <ul class="nav">

        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="menu-icon fa-solid fa-house"></i>
            <span class="menu-title">Trang chủ</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('students.index') }}">
            <i class="menu-icon fa-solid fa-book-open-reader"></i>
            <span class="menu-title">Quản lý học sinh</span>
          </a>
        </li>
    
        <li class="nav-item">
          <a class="nav-link" href="{{ route('classrooms.index') }}">
            <i class="menu-icon fa-solid fa-chalkboard"></i>
            <span class="menu-title">Quản lý lớp học</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="ui-basic">
            <i class="icon-layout menu-icon fa-solid fa-chart-simple"></i>
            <span class="menu-title">Báo cáo tổng kết</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="reports">
            <ul class="nav flex-column sub-menu" style="padding: 0 10px 10px 10px;">
              <li class="nav-item"> <a class="nav-link" href="{{ route('reports.classroom') }}" >Tổng kết lớp học</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('reports.subject') }}">Tổng kết môn học</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('reports.semester') }}">Tổng kết học kỳ</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('reports.year') }}">Tổng kết năm học</a></li>
            </ul>
          </div>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" data-toggle="collapse" href="#generals" aria-expanded="false" aria-controls="ui-basic">
            <i class="icon-layout menu-icon fa-solid fa-circle-exclamation"></i>
            <span class="menu-title">Quản lý chung</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="generals">
            <ul class="nav flex-column sub-menu" style="padding: 0 10px 10px 10px;">
              <li class="nav-item"> <a class="nav-link" href="{{ route('rules.index') }}">Quản lý quy định</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('schoolYears.index') }}">Quản lý niên khóa</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('markTypes.index') }}">Quản lý học vụ</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('subjects.index') }}">Quản lý môn học</a></li>
            </ul>
          </div>
        </li>
      </ul>
      @break
    @case(2)
      <ul class="nav">
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="menu-icon fa-solid fa-house"></i>
            <span class="menu-title">Trang chủ</span>
          </a>
        </li>

      </ul>
      @break
      @case(3)
      <ul class="nav">
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="menu-icon fa-solid fa-house"></i>
            <span class="menu-title">Trang chủ</span>
          </a>
        </li>

      </ul>
      @break
          
  @endswitch
 
</nav>
