@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.15/css/jquery.dataTables.min.css">
@section('content')
    <!-- Header -->
    @include('includes.header')


    <!-- Main Content -->
    {{-- <div class="container"> --}}
        <div class="row justify-content-center">
            <div class="col-md-3">
                @include('includes.sidebar')
            </div>
            <div class="col-md-8">
                <br><br><br>
                        <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Course-specific inquiry</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('course-list') }}">Course List</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Course-specific inquiry</li>
                    </ol>
                </nav>
                <div class="card">
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue">Course</b></div>
                    <h3>Course Classification: </h3>
                    <h3>Course Classification Details: </h3>
                    <h3>Course Name: </h3><br><br>
                    <div class="card-header" style="background-color: darkblue"><b style="color:aliceblue"> Employees attending the course</b></div>