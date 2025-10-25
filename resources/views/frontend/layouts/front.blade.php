<!DOCTYPE html>
<html lang="en">

<head>
  @include('frontend.layouts.head')

</head>

<body class="body-wrapper">
    @include('frontend.layouts.preloadder')
    <!-- welcome content start from here -->

   @include('frontend.layouts.header')
    <div class="header-gutter"></div><!-- /header-gutter -->

    @yield('content')


    @include('frontend.layouts.footer')
</body>

</html>
