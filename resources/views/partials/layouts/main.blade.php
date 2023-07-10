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

    @include('partials.navbar')

    <div class="container-fluid page-body-wrapper">

      @include('partials.sidebar')

      <div class="main-panel">

        <div class="content-wrapper">

          @yield('content')

          
          @include('partials.footer')

        </div>

      </div>

    </div>

    <x-flash-message></x-flash-message>
    <x-delete-confirm-modal></x-delete-confirm-modal>
  </div>


  <script src="{{ asset('js/ui.js') }}"></script>
  <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('js/template.js') }}"></script>
  <script>
    function handleDelete(url, message) {
      const deleteConfirmModal = document.querySelector('#deleteConfirmModal');
      const deleteConfirmForm = document.querySelector('#deleteConfirmForm');
      const modalMessage = document.querySelector('#deleteConfirmModal .modal-message');
      modalMessage.innerHTML = 'Bạn có chắc muốn xóa ' + message + ' ?';
      deleteConfirmForm.action = url;
    }
  </script>
  @stack('js')

</body>

</html>
