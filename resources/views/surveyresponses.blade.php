@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
<style>
    /* Style untuk textarea */
    textarea {
        resize: both; /* Membuat textarea bisa diresize */
        overflow: auto; /* Menambahkan scrollbar jika konten terlalu besar */
        width: 100%; /* Lebar textarea */
        height: 150px; /* Tinggi textarea */
    }

    .sticky-list-group {
        position: sticky;
        top: 10px; /* Anda dapat menyesuaikan offset atas sesuai kebutuhan */
    }
</style>

@section('content')
    <!-- Header -->
    @include('includes.header')


    <!-- Main Content -->
    {{-- <div class="container"> --}}
        <div class="row justify-content-center">
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>
            <div class="col-md-6">
                <br><br><br>
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="List of courses taken">撮影したコースのリスト</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('employee-list') }}" title="Attendance">出席</a></li>
                        <li class="breadcrumb-item active" aria-current="page" title="Post-course ToDo">コースポストトッド</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue" title="Course information"><b style="color:aliceblue">コース情報</b></div>
                        <div class="card-body">
                            <div class="card-header" title="Course information" style="background-color: #92CDFC" align="center"><b style="color:aliceblue">コース情報</b></div>
                            <!-- DataTable -->
                            <table id="employeelistTable" class="display table table-bordered table-striped table-hover responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th title="Course Name">コース名</th>
                                        <th title="Deadline for enrollment">登録の締め切り</th>
                                        <th title="ToDo">全て</th>
                                    </tr>
                                </thead>