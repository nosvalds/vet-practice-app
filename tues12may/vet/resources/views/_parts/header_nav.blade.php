<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">Wildlife Supreme</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/owners">Owners</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/animals">Animals</a>
                </li>
            </ul>
        </div>
        <form class="form-inline mr-sm-2" method="get" action="/owners/">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" name="search_string" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search Owners</button>
        </form>
        @if ($logged_in ?? '') {{-- If logged in = true indicate that --}}
            <a class="btn btn-primary" href="/login" role="button">{{ $user->name }}</a>
        @else  {{-- If not logged in, login button --}}
            <a class="btn btn-primary" href="/login" role="button">Login</a>
        @endif
    </nav>
</header>