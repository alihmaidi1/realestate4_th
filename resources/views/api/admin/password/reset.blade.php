<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reset Code</title>

  <style>
    .button {
      background-color: #4CAF50;
      /* Green */
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
    }
  </style>
</head>

<body>
  <div>Hello You Can Reset password By This Code :</div>
  <h3 style="text-align:center">{{ $reset_code }}</h3>
  @if ($SignedUrl != '')
    {{-- <a href="{{ $SignedUrl }}" class="button">go</a> --}}
  @endif
</body>

</html>
