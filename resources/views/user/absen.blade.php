<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Absen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absen as $d)
                @for ($i = 1; $i <= 31; $i++)
                    @php
                        $field = 'tgl_' . $i; // Nama kolom tanggal, misal tgl_1, tgl_2, dst.
                    @endphp
                    @if (!empty($d->$i))
                        <!-- Cek apakah kolom ada isinya -->
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $i }}/10/2024</td>
                        </tr>
                    @endif
                @endfor
            @endforeach
        </tbody>
    </table>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

</body>

</html>
