@props(['no_invoice', 'tanggal', 'title', 'printCount' => 0])


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            position: relative;
        }

        .print-watermark {
            position: absolute;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            color: rgba(0, 0, 0, 0.08);
            font-size: 8rem;
            font-weight: 800;
            letter-spacing: 0.5em;
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
        }

        .print-content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body>
    @if(($printCount ?? 0) > 1)
        <div class="print-watermark">{{ 'COPY ' . $printCount }}</div>
    @endif
    <div class="container p-2 print-content">
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
