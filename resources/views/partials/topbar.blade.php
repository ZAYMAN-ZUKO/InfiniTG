<div class="top">

    <form action="{{ route('search') }}" method="GET">

        <input
            type="text"
            name="search"
            class="search"
            placeholder="Search files..."
            value="{{ request('search') }}"
        >

    </form>

    <div class="avatar">
        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
    </div>

</div>