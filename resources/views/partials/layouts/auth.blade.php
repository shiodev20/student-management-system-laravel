<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="{{ asset('images/logo-mini.svg') }}">
  <link rel="stylesheet" href="{{ asset('vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/font-awesome/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <title>{{ env('APP_NAME') }} | @yield('documentTitle')</title>
</head>

<body>

  <div class="container-scroller">

    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="main-panel w-100">
        <div class="content-wrapper d-flex align-items-center auth px-0">

          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                @yield('content')

              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <x-flash-message></x-flash-message>
  </div>


  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}""></script>
  <script src="{{ asset('js/template.js') }}"></script>
  <script src="{{ asset('js/ui.js') }}"></script>
  
</body>

</html>
