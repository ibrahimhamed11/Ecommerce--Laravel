
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <button class="btn btn-success  dropdown-toggle" type="button" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bi bi-bell"></i> Notifications <span id="notificationBadge" class="badge badge-danger">0</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="notificationDropdown" id="notificationDropdownMenu">
                </div>
            </li>
            <ul class="navbar-nav" id="navList" style="margin-left: 20px;">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('admin') }}"><strong style="font-size: 18px;">Home</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('users') }}"><strong style="font-size: 18px;">Users</strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('products') }}"><strong style="font-size: 18px;">Products</strong></a>
                </li>
            </ul>
        </ul>
        <button class="btn btn-outline-danger my-2 my-sm-0" onclick="logout()">Logout</button>
    </div>
</nav>
