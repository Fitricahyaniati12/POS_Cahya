<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Level</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Data Level</h2>
    <table>
        <thead>
            <tr>
                <th>Level ID</th>
                <th>Level Kode</th>
                <th>Level Nama</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->level_id }}</td>
                <td>{{ $row->level_kode }}</td>
                <td>{{ $row->level_nama }}</td>
                <td>{{ $row->created_at }}</td>
                <td>{{ $row->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
