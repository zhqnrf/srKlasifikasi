<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<body>
    @include('partial.headbar')
    @include('partial.sidebar-santri')
    @yield('content')
    @include('layouts.footer')

</body>

</html>