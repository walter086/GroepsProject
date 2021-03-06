
@extends('layouts.app')

@section('content')

        


<div class="row" style="margin-top: 20px;">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Latest Products</h3></div>
                    <div class="panel-body">
                        @if(count($products))
                            <ul class="list-group">
                             @foreach($products as $product)
                            <li class="list-group-item"><a href="/product/{{$product->id}}"><h4>{{$product->name}}</h4></a><p> in Stock: {{$product->stock}}</p>
                                @if(!Auth::guest())
                                @if(Auth::user()->authorization_level != 1)
    
                                    @else
                                 <a href="/product/{{$product->id}}/edit" class="btn btn-secondary btn-lg" style= "float:right">Edit</a>
                            {!!Form::open(['action' => ['ProductsController@destroy', $product->id], 'method' => 'POST', 'class' => 'float-right'])!!}
                            {{Form::hidden('_method','DELETE')}}
                            {{Form::submit('Delete', ['class' => 'btn btn-danger btn-lg'])}}
                            {!!Form::close()!!}
                            @endif
                            @endif
                            </li>
                            @endforeach
                        </ul>
                    @else
                      <p>No Products Found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
