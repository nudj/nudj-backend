@extends('admin.app')


@section('page')

    <div class="outer">

        @include('admin.partial.sidebar')

        <!-- Mainbar starts -->
        <div class="mainbar">

            <!-- Mainbar head starts -->
            <div class="main-head">

                @include('admin.partial.head')

            </div>


            <!-- Mainbar head ends -->
            <div class="main-content">

                <div class="container">
                    @yield('content')
                </div>
            </div>

        </div>
        <!-- Mainbar ends -->

    </div>

@endsection


@section('runnable')
    @parent
@endsection
