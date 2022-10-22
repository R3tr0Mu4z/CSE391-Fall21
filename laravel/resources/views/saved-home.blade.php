@extends('layouts.app')
@section('title', 'Saved Search')

@section('content')

<script>
    var save = true
    var save_search_id = "{{$data['id']}}"
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2 class="h2-header text-center">{{ __('Search Properties') }}</h2>
                    <div id="map" style="height: 400px;">

                    </div>
                    <form method="POST" id="search-form">
                        <div class="row">
                            <div class="col-md-4 form-group mt10">
                                <select name="district" class="form-control" id="district" data-val="{{$data['district']}}">
                                    <option value="">Select District</option>
                                    <option value="Dhaka">Dhaka</option>
                                    <option value="Mymensigh">Mymensigh</option>
                                    <option value="Khulna">Khulna</option>
                                    <option value="Rangpur">Rangpur</option>
                                    <option value="Sylet">Sylet</option>
                                    <option value="Chittagong">Chittagong</option>
                                    <option value="Barisal">Barisal</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mt10">
                                <select name="city" class="form-control" id="city" data-val="{{$data['city']}}" data-delay="100">
                                    <option value="">Select City</option>
                                </select>

                            </div>
                            <div class="col-md-4 form-group mt10">
                                <input type="number" class="form-control" name="postal" placeholder="Postal Code" data-val="{{$data['postal']}}" />
                            </div>
                            <div class="col-md-4 form-group mt10">
                                <select name="property_type" class="form-control" data-val="{{$data['property_type']}}">
                                    <option value="">Property Type</option>
                                    <option value="Flat">Flat</option>
                                    <option value="House">House</option>
                                    <option value="Rent">Rent</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group mt10">
                                <input type="number" class="form-control" name="bed" placeholder="Minimum Bedrooms" data-val="{{$data['bed']}}" />
                            </div>
                            <div class="col-md-4 form-group mt10">
                                <input type="number" class="form-control" name="bath" placeholder="Minimum Bathrooms" data-val="{{$data['bath']}}"  />
                            </div>

                            <div class="col-md-12 text-center mt10">
                                <div class="row">
                                    <div class="col-md-6 form-group mt10">
                                        <input type="number" class="form-control" name="min" placeholder="Minimum Cost" data-val="{{$data['min']}}"  />
                                    </div>
                                    <div class="col-md-6 form-group mt10">
                                        <input type="number" class="form-control" name="max" placeholder="Maximum Cost" data-val="{{$data['max']}}"  />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt10">
                                <button id="search" class="btn btn-success search-btn">
                                    Search
                                </button>
                                <button id="save-search" class="btn btn-danger search-btn">
                                    Update Search
                                </button>
                                <button id="delete-search" class="btn btn-danger search-btn">
                                    Delete Search
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="coords" name="coords" data-val="{{$data['coords']}}" />
                        <input type="hidden" id="layer_type" name="layer_type"  data-val="{{$data['layer_type']}}" />
                    </form>
                </div>
            </div>

            <div class="card mt40 search-results" style="display: none;">
                <div class="card-body">
                    <h2 class="h2-header text-center">{{ __('Search Results') }}</h2>

                    <div class="card-body results-append">





                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal search-modal fade hide" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form id="save-search-form">
        <div class="modal-header">
            <h5 class="modal-title">Enter Search Name</h5>
            <button type="button" class="close btn btn-danger " data-dismiss="modal" aria-label="Close" onclick="$('.search-modal').modal('hide')"">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <input class="form-control" name="save_search_name" id="save_search_name" required value="{{$data['save_search_name']}}" />
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" value="" id="map_base64" />
            <input type="hidden" value="" id="area_selected" />
            <input type="submit" class="btn btn-primary" value="Save Search" />
        </div>
        </div>
    </form>
  </div>
</div>

<style>
    .result-item img {
        height: 100%;
        object-fit: cover;
    }

    .result-item.selected {
        background-color: #cfffd0;
    }
</style>
@endsection