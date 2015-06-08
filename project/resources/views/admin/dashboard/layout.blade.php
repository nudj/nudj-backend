@extends('app')


@section('page')

    <div class="outer">

        @include('dashboard.partial.sidebar')

        <!-- Mainbar starts -->
        <div class="mainbar">

            <!-- Mainbar head starts -->
            <div class="main-head">

                @include('dashboard.partial.head')

            </div>


            <!-- Mainbar head ends -->
            <div class="main-content">

                @yield('content')

            </div>

        </div>
        <!-- Mainbar ends -->

    </div>

@endsection


@section('runnable')
    @parent
@endsection
