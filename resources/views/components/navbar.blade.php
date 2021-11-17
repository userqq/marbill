<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Marbill</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto justify-content-end">
                <li class="{{ Request::is('customers') ? 'nav-item active' : 'nav-item' }}">
                    <a class="nav-link" href="{{ route('customers') }}">Customers</a>
                </li>
                <li class="{{ Request::is('customers-groups') ? 'nav-item active' : 'nav-item' }}">
                    <a class="nav-link" href="{{ route('customers-groups') }}">Customers Groups</a>
                </li>
                <li class="{{ Request::is('templates') ? 'nav-item active' : 'nav-item' }}">
                    <a class="nav-link" href="{{ route('templates') }}">Templates</a>
                </li>
            </ul>
        </div>
    </div>
</nav>