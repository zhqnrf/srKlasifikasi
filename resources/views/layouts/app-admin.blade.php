<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<body>
    @include('partial.headbar-admin')
    @include('partial.sidebar-admin')
    @yield('content')
    @include('layouts.footer')

</body>

</html>