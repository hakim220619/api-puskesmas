<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>

    <h2>Data Bayi</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jenis Kelamin</th>
            <th>Bb Lahir</th>
            <th>Tb Lahir</th>
            <th>Nama Ortu</th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($users as $a)
            <tr>
                <th>{{ $no++ }}</th>
                <th>{{ $a->name }}</th>
                <th>{{ $a->email }}</th>
                <th>{{ $a->jenis_kelamin }}</th>
                <th>{{ $a->bb_lahir }}</th>
                <th>{{ $a->tb_lahir }}</th>
                <th>{{ $a->nama_ortu }}</th>
            </tr>
        @endforeach
    </table>

</body>

</html>
