<!DOCTYPE html>
<html>
<head>
    <title>Appologize</title>
    <style>
        body {
            margin: 0 auto;
            padding: 50px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <h1>Dear {{ $user->name }},</h1>
    <h3>{{ $details['title'] }}</h3>
    <p>{{ $details['body'] }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Image</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $product->name_en }}</td>
                <td><img src="{{ asset('images/product/'.$product->photo) }}" style="width:30%;"></td>
            </tr>
        </tbody>
    </table>
   
    <p>Thank you</p>
</body>
</html>