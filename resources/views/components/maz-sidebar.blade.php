@props(['href', 'title' => 'Menu'])
<style>
    .sidebar-wrapper .sidebar-header img {
        height: 5.2rem;
        margin-left: 90%;
    }
</style>
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">

        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ $href }}"><img src="{{globalVar('appUrl')}}"
                            alt="Logo" srcset=""></a>
                </div>

                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">{{ $title }}</li>
                {{ $slot ?? '' }}
            </ul>
        </div>

    </div>
</div>
