@props(['no_invoice', 'tanggal', 'title'])


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container p-2">
        <div class="row align-items-start mt-4 mb-2">
            <!-- Kolom Kiri - Logo dan Invoice -->
            <div class="col-md-6">
                <div class="d-flex align-items-start gap-2">
                    <img style="height: 5.2rem" src="{{ globalVar('appUrl') }}" alt="">
                    <div>
                        <h6>
                            {{$title}} : #{{ $no_invoice }}
                            <div class="text-muted">
                                <p style="font-size: 13px">Tanggal : {{ tglFormat($tanggal) }}</p>
                            </div>
                        </h6>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                {{$table ?? ''}}
            </div>
            <!-- Kolom Kanan - Tabel -->
            
        </div>
        {{ $slot }}

        <div class="mt-5">
            <div class="row">
                <div class="col text-center">
                    <p>Penerima,</p>
                    <br><br>
                    <p>(___________________)</p>
                </div>
                <div class="col text-center">
                    <p>Mengetahui,</p>
                    <br><br>
                    <p>(___________________)</p>
                </div>
                <div class="col text-center">
                    <p>Disetujui,</p>
                    <br><br>
                    <p>(___________________)</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
