@extends('admin.index')
@section('content')
<div class="container">
    <h1>{{$product->name}}</h1>
    <img src="/product_images/{{$product->image_name}}" alt="product image">
    <div>
        Description: {{$product->description}}
    </div>
    <div>
        Price: {{$product->price}}
    </div>
    <div>
        Stock: {{$product->stock}}
    </div>
    <div>
            
        Category: {{$product->category->name}}
    </div> 
    @if(!Auth::guest())
    @if(Auth::user()->authorization_level != 1)
    
    @else
   <a href="/product/{{$product->id}}/edit" class="btn btn-primary">Edit</a>

{!!Form::open(['action' => ['ProductsController@destroy', $product->id], 'method' => 'POST', 'class' => 'float-right'])!!}
    {{Form::hidden('_method', 'DELETE')}}
    {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
{!!Form::close()!!}

@endif
@endif
@endsection
