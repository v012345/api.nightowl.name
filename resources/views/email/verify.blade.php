<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
</head>

<body>
    <h1>Verify your email</h1>
    <p> Click below url to verify your email address so we know it’s really you.</p>
    <p> <a href="{{ route('verify_email', 1) }}">
            {{ route('verify_email', 1) }}
        </a> </p>
    <p> (This email is sent automatically by the system, please do not reply.) </p>
</body>

</html>
