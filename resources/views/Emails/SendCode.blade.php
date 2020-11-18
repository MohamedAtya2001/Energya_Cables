<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mailer Atya</title>

    <link rel="stylesheet" href="{{asset('layout/css/bootstrap.min.css')}}">
</head>

<body>

    <div class="container">

        <h1>Hello {{$details['name']}}</h1>
        <h4>This Is Your Code : {{$details['code']}}</h4>

    </div>


</body>

</html>