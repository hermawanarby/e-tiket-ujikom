<ul class="sidebar navbar-nav navbar-light" style="background-color:#00008b;">
    <li class="nav-item">
        <a class="nav-link" href="{{route('home')}}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
        </a>
    </li>

    @if (Auth::user()->level == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{route('pengguna.data')}}">
        <i class="fas fa-fw fa-user"></i>
        <span>Pengguna</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('transportation-type.data')}}">
        <i class="fas fa-fw fa-tags"></i>
        <span>Tipe Transportasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('transportation.data')}}">
        <i class="fas fa-fw fa-plane"></i>
        <span>Transportasi</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('rute.data')}}">
        <i class="fas fa-fw fa-road"></i>
        <span>Rute</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('report')}}">
        <i class="fas fa-fw fa-print"></i>
        <span>Laporan</span>
        </a>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link" href="{{route('customer.data')}}">
        <i class="fas fa-fw fa-users"></i>
        <span>Pelanggan</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{route('reservation.data')}}">
        <i class="fas fa-fw fa-calendar-alt"></i>
        <span>Reservation</span>
        </a>
    </li>

</ul>
