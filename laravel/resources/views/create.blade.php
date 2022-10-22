@extends('layouts.app')
@section('title', 'Create Listing')
@section('content')

<script>
    var owner = true
    var edit = false
</script>

<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt40 col-md-8 offset-md-2">
                <div class="card-body">
                    <h2 class="text-center">
                        Create Property Listing
                    </h2>
                    <form id="create-listing" method="POST" action="{{url('/post')}}">
                        @csrf
                        <div class="mt10">
                            <h5 class="text-center">Click on map to place marker</h5>
                            <div id="map" style="height: 400px;"></div>
                        </div>
                        <input type="hidden" name="lat_lng" id="lat_lng" value="" />
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
                        <input type="hidden" name="img_urls" id="images" value="" />
                        <div class="form-group">
                            <select class="form-control mt10" id="property_type_changer" name="type" required>
                                <option value="">Property Type</option>
                                <option value="Flat">Flat</option>
                                <option value="House">House</option>
                                <option value="Rent">Rent</option>
                            </select>
                        </div>

                        <div class="form-group mt10 flat_details property_type_fields">
                            <input type="text" placeholder="Enter Flat No/Unit" name="flat_details" class="form-control" />
                        </div>

                        <div class="form-group mt10 house_details property_type_fields">
                            <input type="text" placeholder="Enter House No/Details" name="house_details" class="form-control" />
                        </div>

                        <div class="form-group mt10">
                            <select class="form-control" name="district" id="district" required>
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
                        <div class="form-group mt10">
                            <select name="city" class="form-control" name="city" id="city" required>
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div class="form-group mt10">
                            <input type="text" class="form-control" name="street" placeholder="Street No. / Name" required />
                        </div>
                        <div class="form-group mt10">
                            <input type="number" class="form-control" name="postal" placeholder="Postal Code" required />
                        </div>
                        <div class="form-group mt10">
                            <input type="number" class="form-control" name="bed" placeholder="Bedrooms" required />
                        </div>
                        <div class="form-group mt10">
                            <input type="number" class="form-control" name="bath" placeholder="Bathrooms" required />
                        </div>
                        <div class="form-group mt10">
                            <input type="number" class="form-control" name="cost" id="cost" placeholder="Cost (Tk)" required />
                        </div>
                        <div class="form-group mt10">
                            <input type="text" class="form-control" name="size" placeholder="Size" required />
                        </div>

                        <div class="form-group mt10">
                            <textarea class="form-control" name="description" placeholder="Description"></textarea>
                        </div>


                        <div class="text-center mt10">
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>

</div>

<style>
    #drop_file_zone {
        background-color: #EEE;
        border: #999 5px dashed;
        padding: 8px;
        font-size: 18px;
        width: 90%;
        margin: auto;
    }

    #drag_upload_file {
        margin: 0 auto;
        width: 100%;
    }

    #drag_upload_file p {
        text-align: center;
    }

    #drag_upload_file #selectfile {
        display: none;
    }

    .selected-images img {
        width: 80px;
        margin: 5px;
        display: inline-block;
    }
</style>


@endsection