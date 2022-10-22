@extends('layouts.app')
@section('title', 'Notifications')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">


                <div class="card-body">
                    <h2 class="h2-header text-center">{{ __('Notifications') }}</h2>
                    <div class="row">

                        @foreach($notifications as $notification)
                        <div class="notification-item col-md-12 {{$notification['seen'] ? 'seen' : 'unseen'}}" >
                            <div class="row">
                                <div class="col-md-2">
                                    @php
                                        $img = explode("~-~", $notification['img_urls'])[0];
                                        $date = strtotime($notification['time_added']);
                                        $show_date =  date('d M Y', $date);
                                    @endphp
                                    <div class="notification_img_wrapper">
                                        <img src="{{$img}}" class="img-fluid" />
                                        @if ($notification['seen'] == 0)
                                            <span class="new_notification">
                                                NEW
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-10 notification_content">
                                    <p>New Property at <a href="{{url('/property/')}}/{{$notification['property_id']}}"><b>{{$notification['street']}}, {{$notification['city']}}, {{$notification['district']}} {{$notification['postal']}}</b></a> has been added matching your saved search <a href="{{url('/saved-search/')}}/{{$notification['saved_id']}}"><b>{{$notification['saved_name']}}</b></a> on {{$show_date}}</p>
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