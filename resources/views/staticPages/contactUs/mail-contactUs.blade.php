<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>

    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mr-auto">
                <p>User Name: <span>{{$data['name']}}</span></p>
                <p>Email: <span>{{$data['email']}}</span></p>
                <p>Subject: <span>{{$data['subject']}}</span></p>
                <p>Message: <span>{{$data['message']}}</span></p>
                <p>Created At: <span>{{$data['created_at']}}</span></p>
            </div>
        </div>
    </div>
</body>
</html>