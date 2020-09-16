<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  </head>
  <body>
    <table class="table table-bordered">
    <thead>
      <tr class="table-danger">
        <th>Id</th>
        <th>Owner</th>
        <th>Level</th>
        <th>Extract Data</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($ocr as $data)
        <tr>
            <td>{{ $data->msgocrid }}</td>
            <td>{{ $data->user_id }}</td>
            <td>{{ $data->title }}</td>
            <td>{{ $data->content }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>