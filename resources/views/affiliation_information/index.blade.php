@extends('layouts.app')

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Affiliation Information</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Affiliation Code</th>
                                <th scope="col">Company ID</th>
                                <th scope="col">Affiliation Name</th>
                                <th scope="col">Display Order</th>
                                <th scope="col">Organization Type</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($affiliations as $affiliation)
                            <tr>
                                <td>{{ $affiliation->affiliation_code }}</td>
                                <td>{{ $affiliation->company_id }}</td>
                                <td>{{ $affiliation->affiliation_name }}</td>
                                <td>{{ $affiliation->display_order }}</td>
                                <td>{{ $affiliation->organization_type }}</td>
                                <td>
                                    <a href="{{ route('affiliation-information.show', $affiliation->id) }}" class="btn btn-primary"><i class="fas fa-eye"></i> View</a>
                                    <a href="{{ route('affiliation-information.edit', $affiliation->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('affiliation-information.destroy', $affiliation->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
