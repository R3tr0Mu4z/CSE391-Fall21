<?php

namespace App\Http\Controllers;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserPropertyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {

    }


    public function create()
    {
        return view('create');
    }

    public function edit($id) {
        $user = Auth::user()->id;
        $query = Property::query();
        $query = $query->select('id', 'user', 'street', 'district', 'city', 'postal', 'cost', 'type', 'bath', 'bed', 'size', 'flat_details', 'house_details', 'description', 'img_urls', 'lat', 'lng')
        ->where('id', '=', $id)
        ->where('user', '=', $user)
        ->first();
        if (!empty($query)) {
            $property = $query->toArray();
            return view('edit', ['property' => $property]);
        } else {
            echo "Invalid ID";
            exit;
        }
    
    }

    public function listings()
    {
        $user = Auth::user()->id;
        $query = Property::query();

        $properties = $query->select('id', 'street', 'district', 'city', 'postal', 'cost', 'type', 'bath', 'bed', 'size', 'description', 'img_urls', 'lat', 'lng')
        ->where('user', '=', $user)
        ->orderBy('id', 'DESC')
        ->get()
        ->toArray();
        
        foreach($properties as $k => $v) {
            $properties[$k]['img'] = explode("~-~", $properties[$k]['img_urls'])[0];
        }


        return view('listings', ['properties' => $properties]);
    }

    public function post(Request $request) {

        $validator = Validator::make($request->all(), [
            'lat_lng' => 'required',
            'bath' => 'required',
            'bed' => 'required',
            'city' => 'required',
            'cost' => 'required',
            'district' => 'required',
            'img_urls' => 'required',
            'postal' => 'required',
            'street' => 'required',
            'type' => 'required',
            'size' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('message', 'Fields can not be empty');
            Session::flash('icon', 'error');
            return redirect('/create');
        }

        $validated = $validator->validated();

        $lat = explode(",",$validated['lat_lng'])[0];
        $lng = explode(",",$validated['lat_lng'])[1];

        $property = new Property;
        $property->bath = $validated['bath'];
        $property->bed = $validated['bed'];
        $property->city = $validated['city'];
        $property->cost = $validated['cost'];
        $property->description = $request->description;
        $property->district = $validated['district'];
        $property->img_urls = $validated['img_urls'];
        $spatial = "(GeomFromText('POINT({$lat} {$lng})'))";
        $property->loc = DB::raw($spatial);
        $property->lat = $lat;
        $property->lng = $lng;
        $property->postal = $validated['postal'];
        $property->street = $validated['street'];
        $property->type = $validated['type'];
        $property->size = $validated['size'];
        $property->flat_details = $request->flat_details;
        $property->house_details = $request->house_details;
        $property->size = $validated['size'];
        $property->user =  Auth::user()->id;

        $insert = $property->save();
        
        if ($insert) {
            Session::flash('message', 'Listing Created!');
            Session::flash('icon', 'success');
            return redirect("/property/{$property->id}");
        }
    }

    public function update(Request $request) {

        $validator = Validator::make($request->all(), [
            'property_id' => 'required',
            'lat_lng' => 'required',
            'bath' => 'required',
            'bed' => 'required',
            'city' => 'required',
            'cost' => 'required',
            'district' => 'required',
            'img_urls' => 'required',
            'postal' => 'required',
            'street' => 'required',
            'type' => 'required',
            'size' => 'required',
        ]);

        if ($validator->fails()) {
            Session::flash('message', 'Fields can not be empty');
            Session::flash('icon', 'error');
            if (empty($request->id)) {
                return redirect('/');
            } else {
                return redirect("/edit-property/{$request->id}");
            }
        }

        $validated = $validator->validated();

        $lat = explode(",",$validated['lat_lng'])[0];
        $lng = explode(",",$validated['lat_lng'])[1];
        $data = [];
        

        $data['bath'] = $validated['bath'];
        $data['bed'] = $validated['bed'];
        $data['city'] = $validated['city'];
        $data['cost'] = $validated['cost'];
        $data['description'] = $request->description;
        $data['district'] = $validated['district'];
        $data['img_urls'] = $validated['img_urls'];
        $spatial = "(GeomFromText('POINT({$lat} {$lng})'))";
        $data['loc'] = DB::raw($spatial);
        $data['lat'] = $lat;
        $data['lng'] = $lng;
        $data['postal'] = $validated['postal'];
        $data['street'] = $validated['street'];
        $data['type'] = $validated['type'];
        $data['size'] = $validated['size'];
        $data['flat_details'] = $request->flat_details;
        $data['house_details'] = $request->house_details;

        $update = Property::where('id', $validated['property_id'])
        ->where('user', Auth::user()->id)
        ->update($data);


        if ($update) {
            Session::flash('message', 'Listing Updated!');
            Session::flash('icon', 'success');
            return redirect("/property/{$validated['property_id']}");
        }
    }

    public function delete($id) {
        $user = Auth::user()->id;
        $query = Property::query();
        $delete = $query->select('id', 'user', 'street', 'district', 'city', 'postal', 'cost', 'type', 'bath', 'bed', 'size', 'description', 'img_urls', 'lat', 'lng')
        ->where('id', '=', $id)
        ->where('user', '=', $user)
        ->delete();
        if ($delete) {
            Session::flash('message', 'Listing Deleted!');
            Session::flash('icon', 'success');
            return redirect("/listings");
        }
    }

}
