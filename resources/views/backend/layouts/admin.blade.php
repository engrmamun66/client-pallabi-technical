<!doctype html>
<html>
<head>
    @include('backend.layouts.head')
</head>
<body>
<div class="app-container app-theme-white fixed-sidebar fixed-header body-tabs-line">
    @include('backend.layouts.topbar')
    <div class="app-main">
        @include('backend.layouts.sidebar')
        <div class="app-main__outer">
            <div class="app-main__inner">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="app-wrapper-footer">
        @include('backend.layouts.footer')
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
        @include('backend.layouts.modal')
        @include('backend.layouts.datatable')
    </div>
</div>
</body>
</html>
