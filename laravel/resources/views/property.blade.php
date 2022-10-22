@extends('layouts.app')
@section('title', 'Property Details')
@section('content')

@php
    $view_form = true;
@endphp

@auth
    @php
        $auth_id = Auth::id();
        if ($auth_id === $user) {
            $view_form = false;
        }
    @endphp
@endauth


<script>
    var center = [{{$property['lat']}}, {{$property['lng']}}];
    var property_details = true
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">


                <div class="card-body">
                    <div class="outer">
                        <div id="big" class="owl-carousel owl-theme">

                            @foreach ($images as $img)
                            <div class="item">
                                <img src="{{$img}}" class="img-fluid" />
                            </div>
                            @endforeach

                        </div>
                        <div id="thumbs" class="owl-carousel owl-theme">
                            @foreach ($images as $img)
                            <div class="item">
                            <img src="{{$img}}" class="img-fluid" />
                            </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt40">
                <div class="card-body">
                    <h2 class="text-center">
                        Property Details
                    </h2>
                    <p>
                        <b>
                            Property Type :
                        </b>
                        <span>{{$property['type']}}</span>
                    </p>
                    <p>
                        <b>
                            Bedrooms :
                        </b>
                        <span>{{$property['bed']}}</span>
                    </p>
                    <p>
                        <b>
                            Bathrooms :
                        </b>
                        <span>{{$property['bath']}}</span>
                    </p>
                    <p>
                        <b>
                            Street :
                        </b>
                        <span>{{$property['street']}}</span>
                    </p>
                    @if ($property['flat_details'])

                    <p>
                        <b>
                            Flat :
                        </b>
                        <span>{{$property['flat_details']}}</span>
                    </p>
                    @endif
                    @if ($property['house_details'])
                    <p>
                        <b>
                            House :
                        </b>
                        <span>{{$property['house_details']}}</span>
                    </p>
                    @endif
                    <p>
                        <b>
                            City :
                        </b>
                        <span>{{$property['city']}}</span>
                    </p>
                    <p>
                        <b>
                            Postal Code :
                        </b>
                        <span>{{$property['postal']}}</span>
                    </p>
                    <p>
                        <b>
                            District:
                        </b>
                        <span>{{$property['district']}}</span>
                    </p>
                    <p>
                        <b>
                            Owner's Phone :
                        </b>
                        <span>{{$phone}}</span>
                    </p>
                    <p>
                        <b>Description : </b>
                        <span>{{$property['description']}}</span>
                    </p>
                    <p>
                        <b>Size : </b>
                        <span>{{$property['size']}}</span>
                    </p>
                    <p>
                        <b>Cost : </b>
                        <span>{{$property['cost']}} Tk</span>
                    </p>
                </div>
                <div id="map" style="height: 400px; width: 100%;"></div>
            </div>

            @if ($view_form)
            <div class="card mt40">
                <div class="card-body">
                    <div class="col-md-8 offset-md-2">
                        <h2 class="text-center">
                            Contact the owner
                        </h2>
                        <form method="POST" action="{{url('/email')}}">
                            @csrf
                            <input type="hidden" name="property_id" value="{{$property['id']}}" />
                            <div class="form-group">
                                <input class="form-control mt10" type="text" name="name" placeholder="Your Name" required />
                            </div>
                            <div class="form-group">
                                <input class="form-control mt10" type="email" name="email" placeholder="Your Email" required />
                            </div>
                            <div class="form-group">
                                <input class="form-control mt10" type="text" name="phone" placeholder="Your Phone" required />
                            </div>
                            <div class="form-group">
                                <textarea class="form-control mt10" placeholder="Message" name="message" required></textarea>
                            </div>
                            <input type="hidden" name="id" value="{{$property['id']}}" />
                            <div class="text-center mt10">
                                <button class="btn btn-success">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif


        </div>
    </div>
</div>


@endsection