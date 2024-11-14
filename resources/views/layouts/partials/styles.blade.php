<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

<!-- Vendors -->
<link rel="stylesheet" href="{{ asset('/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('/vendors/bootstrap-icons/bootstrap-icons.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="//unpkg.com/alpinejs" defer></script>
<link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<style>
    .pointer {
        cursor: pointer;
    }
    .select2 {
        width: 100% !important;

    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid rgb(183, 182, 182);
        border-radius: 4px;
        height: 35px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000000;
        line-height: 36px;
        /* font-size: 12px; */


    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 35px;
        position: absolute;
        top: 1px;
        right: 1px;
        width: 20px;
    }
</style>
<!-- Styles -->
{{-- <link rel="stylesheet" href="{{ mix('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<link rel="stylesheet" href="{{ mix('css/app-dark.css') }}"> --}}
@vite(['resources/sass/bootstrap.scss', 'resources/sass/themes/dark/app-dark.scss', 'resources/sass/pages/auth.scss', 'resources/sass/app.scss'])

@livewireStyles

{{ $style ?? '' }}
