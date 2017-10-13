@extends('layouts.app')

@section('page_style')
    <style>
        html, body {
            color: #fff;
        }

        .full-height {
            height: 70vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #fff;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    SkAdmin
                </div>

                <div class="links">
                    <a href="{{ route('admin.index') }}">仪表盘</a>
                    <a href="#">文档</a>
                    <a href="#">News</a>
                    <a href="https://seakee.top">博客</a>
                    <a href="https://github.com/seakee">GitHub</a>
                </div>
            </div>
        </div>
    </div>
@endsection
