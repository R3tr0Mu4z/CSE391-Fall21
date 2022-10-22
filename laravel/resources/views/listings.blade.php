@extends('layouts.app')
@section('title', 'My Listings')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="h2-header text-center">{{ __('My Listings') }}</h2>
                    <div class="row">

                        @foreach ($properties as $property)
                        <div class="listing-item col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <img src="{{url($property['img'])}}" class="img-fluid" />
                                </div>
                                <div class="col-md-6">
                                    <p><b class="text-center">{{$property['street']}}, {{$property['city']}}, {{$property['district']}} {{$property['postal']}}</b></p>
                                    <p>{{$property['type']}}</p>
                                    <p>{{$property['bed']}} Bedrooms</p>
                                    <p>{{$property['bath']}} Bathrooms</p>
                                    <p>{{$property['cost']}} Tk</p>
                                    <div class="text-row">
                                        <div class="left-text">
                                            <a href="{{url('/property')}}/{{$property['id']}}" style="color: green">
                                                View
                                            </a>
                                        </div>
                                        <div class="middle-text">
                                            <a href="{{url('/edit-property')}}/{{$property['id']}}">
                                                Edit
                                            </a>
                                        </div>
                                        <div class="right-text">
                                            <a href="{{url('/delete')}}/{{$property['id']}}" class="red">
                                                Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

@endsection