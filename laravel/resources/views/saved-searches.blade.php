@extends('layouts.app')
@section('title', 'Saved Searches')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">


                <div class="card-body">
                    <h2 class="h2-header text-center">{{ __('Saved Searches') }}</h2>
                    <div class="row">

                       @foreach($saved_searches as $search)
                        <div class="saved_search_item">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{url('/saved-search')}}/{{$search['id']}}">{{$search['save_search_name']}}</a>
                                    @if ($search['bed'])
                                    <p>
                                        <b>
                                            Min Bed :
                                        </b>
                                        <span>{{$search['bed']}}</span>
                                    </p>
                                    @endif
                                    @if ($search['bath'])
                                    <p>
                                        <b>
                                            Min Bath :
                                        </b>
                                        <span>{{$search['bath']}}</span>
                                    </p>
                                    @endif
                                    @if ($search['city'])
                                    <p>
                                        <b>
                                            Min City :
                                        </b>
                                        <span>{{$search['city']}}</span>
                                    </p>
                                    @endif
                                    @if ($search['district'])
                                    <p>
                                        <b>
                                            District :
                                        </b>
                                        <span>{{$search['district']}}</span>
                                    </p>
                                    @endif
                                    @if ($search['min'])
                                    <p>
                                        <b>
                                            Min Cost :
                                        </b>
                                        <span>{{$search['min']}}</span>
                                    </p>
                                    @endif
                                    @if ($search['max'])
                                    <p>
                                        <b>
                                            Max Cost :
                                        </b>
                                        <span>{{$search['max']}}</span>
                                    </p>
                                    @endif
                                    @if ($search['property_type'])
                                    <p>
                                        <b>
                                            Property Type :
                                        </b>
                                        <span>{{$search['property_type']}}</span>
                                    </p>
                                    @endif
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