@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>Expense Categories</h1>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td class="text-center">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if($categories->count() == 0)
                    <div class="text-center">
                        <p>No categories available</p>
                    </div>
                @endif

                <div class="pagination">
                    {{ $categories->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
