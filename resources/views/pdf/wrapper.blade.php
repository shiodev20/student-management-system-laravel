<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" href="{{ asset('images/logo-mini.svg') }}">
  <title>{{ env('APP_NAME') }} - @yield('documentTitle')</title>
  <style>
    body {
      font-family: DejaVu Sans;
    }

    ul {
      list-style-type: none;
      padding: 0
    }

    .section {
      margin-bottom: 25px;
    }
    
    .header {
      font-weight: bold;
      font-size: 20px;
      color: #4B49AC;
    }

    .title {
      text-align: center;
      font-size: 20px;
      font-weight: 700;
      text-transform: uppercase;
    }

    .title .subtitle {
      font-size: 15px;
      font-weight: normal;
      text-transform: none;
    }

    .meta {
      font-size: 10px;
      margin-bottom: 10px;
    }

    .meta table {
      width: 50%;
    }

    .data table {
      width: 100%;
      border-collapse: collapse;
    }
    
    .data table, 
    .data th, 
    .data td {
      border: 1px solid black;
    }

    .data th, 
    .data td {
      font-size: 10px;
      padding: 5px 10px;
      width: fit-content;
    }

    .dateExport {
      margin-top: 10px;
      font-size: 10px;
    }
  </style>
</head>
<body>
  <div class="section header">{{ env('APP_NAME') }}</div>

  <div class="section title">
    @yield('title')
    <div class="subtitle">@yield('subtitle')</div>
  </div>

  <div class="section body">

    <div class="meta">
      @yield('meta')
    </div>
    
    <div class="data">
      @yield('data')
    </div>

    <div class="dateExport">
      <i>Ngày in: {{ date('d') }} tháng {{ date('m') }} năm {{ date('Y') }}</i>
    </div>
  </div>

</body>
</html>
