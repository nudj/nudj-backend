<!DOCTYPE html>

<html>
<head>
    <!-- Title -->
    @section('title')
        <title>Default Title</title>
        @show

                <!-- Meta -->
        <meta charset="utf-8">
        <meta name="description" content="Description">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">


        <!-- Styles -->
    @section('styles')
        <link href="{{ asset('assets/web/css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/web/css/select/bootstrap-select.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/web/css/modal-spec.css') }}" rel="stylesheet">
    @show

    @section('scriptses')
        <script src="{{ asset('assets/web/js/jquery-2.2.2.min.js') }}"></script>
        <script>var base_path = '{{web_url()}}'</script>
    @show
</head>

<body>
@section('modal')
<div id="nudjModal" class="modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header header-new">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="titleModal" class="modal-title"></h4>
            </div>
            <div id="bodyModal" class="modal-body modal-body-new"></div>
            <div id="footerModal" class="modal-footer">
                <button type="button" class="btn btn-default btn-new btn-flash" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@show

@yield('page')


<!-- JS -->
@section('scripts')
    <script src="{{ asset('assets/web/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/web/js/select/bootstrap-select.min.js') }}"></script>
@show

@section('runnable')

@show

</body>
</html>