<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="/dashboard">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/manual_register">
                <i class="bi bi-person-plus"></i>
                <span>Manual Register</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/registrants">
                <i class="bi bi-people"></i>
                <span>Registrants</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/payment-logs">
                <i class="bi bi-stack"></i>
                <span>Payment Logs</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="/raffle">
                <i class="bi bi-arrow-repeat"></i>
                <span>Raffle</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ URL::to('/attendance') }}">
                <i class="bi bi-person-check"></i>
                <span>Attendance</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ URL::to('/listOfAttend') }}">
                <i class="bi bi-person-check-fill"></i>
                <span>List of Attend</span>
            </a>
        </li>
        @role('admin')
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ URL::to('/list-users') }}">
                <i class="bi bi-people-fill"></i>
                <span>Users</span>
            </a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="{{ URL::to('/list-roles') }}">
                <i class="bi bi-arrow-repeat"></i>
                <span>Roles</span>
            </a>
        </li> -->
        @endrole
    </ul>

</aside><!-- End Sidebar-->
