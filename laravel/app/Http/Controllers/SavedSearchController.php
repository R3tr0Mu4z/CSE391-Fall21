<?php

namespace App\Http\Controllers;

use App\Models\SavedSearch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SavedSearchController extends Controller
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
    public function index()
    {
        return null;
    }

    
    public function save_search(Request $request) {

        $validator = Validator::make($request->all(), [
                'save_search_name' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('message', 'Enter Save Search Name');
            Session::flash('icon', 'error');
            return redirect('/');
        }

        $validated = $validator->validated();

        $img_name = "";
        if (!empty($request->image_base64)) {
            $image = $request->image_base64;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $img_name = md5(time()).'.png'; 
            Storage::disk('local')->put("/public/images/".$img_name, base64_decode($image));
        }

        $SavedSearch = new SavedSearch();

        $SavedSearch->user = Auth::user()->id;
        $SavedSearch->bath = $request->bath;
        $SavedSearch->bed = $request->bed;
        $SavedSearch->city = $request->city;
        $SavedSearch->coords = $request->coords;
        $SavedSearch->district = $request->district;
        $SavedSearch->layer_type = $request->layer_type;
        $SavedSearch->max = $request->max;
        $SavedSearch->min = $request->min;
        $SavedSearch->postal = $request->postal;
        $SavedSearch->property_type = $request->property_type;
        $SavedSearch->img = $img_name;

        $SavedSearch->save_search_name = $validated['save_search_name'];

        $insert = $SavedSearch->save();

        if ($insert) {
            return response()->json([
                "success" => true,
                "message" => "Search saved."
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Failed to save search."
            ]);
        }
    }

        
    public function update_search($id, Request $request) {

        $validator = Validator::make($request->all(), [
            'save_search_name' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('message', 'Enter Save Search Name');
            Session::flash('icon', 'error');
            return redirect('/');
        }

        $validated = $validator->validated();

        $img_name = "";
        if (!empty($request->image_base64)) {
            $image = $request->image_base64;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $img_name = md5(time()).'.png'; 
            Storage::disk('local')->put("/public/images/".$img_name, base64_decode($image));
        }

        $data = [];
        $data['user'] = Auth::user()->id;
        $data['bath'] = $request->bath;
        $data['bed'] = $request->bed;
        $data['city'] = $request->city;
        $data['coords'] = $request->coords;
        $data['district'] = $request->district;
        $data['layer_type'] = $request->layer_type;
        $data['max'] = $request->max;
        $data['min'] = $request->min;
        $data['postal'] = $request->postal;
        $data['property_type'] = $request->property_type;
        $data['img'] = $img_name;

        $data['save_search_name'] = $validated['save_search_name']; 

        $update = SavedSearch::where('id', $id)
        ->where('user', Auth::user()->id)
        ->update($data);


        if ($update) {
            return response()->json([
                "success" => true,
                "message" => "Search Updated"
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => "Failed to save search."
            ]);
        }
    }


    public function delete_search($id) {
        $delete = SavedSearch::where('id', $id)
        ->where('user', Auth::user()->id)
        ->delete();

        if ($delete) {
            Session::flash('message', 'Saved Search Deleted!');
            Session::flash('icon', 'success');
            return redirect("/");
        } else {
            Session::flash('message', 'There was an error.');
            Session::flash('icon', 'error');
            return redirect("/saved-search/{$id}");
        }
    }

    public function get_saved_search($id) {

        $user = Auth::user()->id;

        $query = SavedSearch::query();

        $data = $query->select('*')->where('user', '=', $user)->where('id', '=', $id);

        if (!empty($data->first())) {
            $data = $data->first()->toArray();
            
            return view('saved-home', ['data' => $data, 'saved' => true]);
        }

    }


    public function saved_searches() {
        $user = Auth::user()->id;
        $query = SavedSearch::query();

        $saved_searches = $query->select('*')->where('user', '=', $user)->orderBy('id', 'DESC')->get()->toArray();

        // print_r($saved_searches);
        return view('saved-searches', ['saved_searches' => $saved_searches]);
    }
}
