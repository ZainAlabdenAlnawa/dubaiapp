@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="table-responsive">
            <h4>Your Products</h4>

            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    @foreach($products as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->description}}</td>
                        <td><img src="{{$item->image}}" class="img-fluid" style="width: 50px" /></td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
