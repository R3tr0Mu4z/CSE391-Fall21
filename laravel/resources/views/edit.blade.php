@extends('layouts.app')
@section('title', 'Edit Listing')
@section('content')

<script>
    var owner = true
    var edit = true
    var center = [{{$property['lat']}}, {{$property['lng']}}];
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt40 col-md-8 offset-md-2">
                <div class="card-body">
                    <h2 class="text-center">
                        Edit Property Listing
                    </h2>
                    <form id="create-listing" method="POST" action="{{url('/update')}}">
                        @csrf
                        <div class="mt10">
                            <h5 class="text-center">Click on map to update marker</h5>
                            <div id="map" style="height: 400px;"></div>
                        </div>
                        <input type="hidden" name="lat_lng" id="lat_lng" value="{{$property['lat']}},{{$property['lng']}}" />
                        <div class="uploader-img">
                            <div id="drop_file_zone" ondrop="upload_file(event)" ondragover="return false">
                                <div id="drag_upload_file">
                                    <p>Drop images(s) here</p>
                                    <p>or</p>
                                    <p><input type="button" value="Select Images(s)" onclick="manual_upload();" /></p>
                                    <input type="file" id="selectfile" multiple />
                                </div>
                            </div>
                        </div>
                        <div class="selected-images">

                        </div>


                        <input type="hidden" name="img_urls" id="images" value="{{$property['img_urls']}}" />
                        <div class="form-group mt5">
                            <span class="small-l">
                                Property Type
                            </span>
                            <select class="form-control" name="type" id="property_type_changer" data-val="{{$property['type']}}" required>
                                <option value="">Property Type</option>
                                <option value="Flat">Flat</option>
                                <option value="House">House</option>
                                <option value="Rent">Rent</option>
                            </select>
                        </div>
                        <div class="form-group mt5 flat_details property_type_fields">
                            <span class="small-l">
                                Flat No/Unit
                            </span>
                            <input type="text" placeholder="Enter Flat No/Unit" value="{{$property['flat_details']}}" name="flat_details" class="form-control" />
                        </div>
                        <div class="form-group mt5 house_details property_type_fields">
                            <span class="small-l">
                                House No/Details
                            </span>
                            <input type="text" placeholder="Enter House No/Details" value="{{$property['house_details']}}" name="house_details" class="form-control" />
                        </div>
                        <div class="form-group mt5">
                            <span class="small-l">
                                District
                            </span>
                            <select class="form-control" name="district" id="district" data-val="{{$property['district']}}" required>
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
                        <div class="form-group mt5">
                            <span class="small-l">
                                City
                            </span>
                            <select name="city" class="form-control" name="city" id="city" data-val="{{$property['city']}}" data-delay='100' required>
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div class="form-group mt5">
                            <span class="small-l">
                                Street
                            </span>
                            <input type="text" class="form-control" name="street" placeholder="Street No. / Name" value="{{$property['street']}}" required />
                        </div>
                        <div class="form-group mt5">
                            <span class="small-l">
                                Postal
                            </span>
                            <input type="number" class="form-control" name="postal" placeholder="Postal Code" value="{{$property['postal']}}" required />
                        </div>
                        <div class="form-group mt5">
                            <span class="small-l">
                                Bedroom
                            </span>
                            <input type="number" class="form-control" name="bed" placeholder="Bedrooms" value="{{$property['bed']}}" required />
                        </div>
                        <div class="form-group mt5">
                            <span class="small-l">
                                Bathroom
                            </span>
                            <input type="number" class="form-control" name="bath" placeholder="Bathrooms" value="{{$property['bath']}}" required />
                        </div>
                        <div class="form-group mt5">
                            <span class="small-l">
                                Cost
                            </span>
                            <input type="number" class="form-control" name="cost" id="cost" placeholder="Cost (Tk)" value="{{$property['cost']}}"  required/>
                        </div>
                        <div class="form-group mt5">
                            <span class="small-l">
                                Size
                            </span>
                            <input type="text" class="form-control" name="size" placeholder="Size" value="{{$property['size']}}" required />
                        </div>

                        <div class="form-group mt5">
                            <span class="small-l">
                                Description
                            </span>
                            <textarea class="form-control" name="description" placeholder="Description">{{$property['description']}}</textarea>
                        </div>
                        <input type="hidden" value="{{$property['id']}}" name="property_id" />

                        <div class="text-center mt5">
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

</div>

@endsection