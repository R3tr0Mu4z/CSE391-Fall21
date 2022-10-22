<?php

namespace App\Http\Controllers;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        
        $query = Property::query();

        $query = $query->select('id', 'user', 'street', 'district', 'city', 'postal', 'cost', 'type', 'bath', 'bed', 'size', 'description', 'img_urls', 'flat_details', 'house_details', 'lat',  'lng')->where('id', '=', $id)->first();
                        
        if (!empty($query)) {
            $property = $query->toArray();

            $user_query = User::query();
            $user_query = $user_query->select('id', 'phone')->where('id', '=', $property['user'])->first();
            
            $phone = $user_query->toArray()['phone'];
            $user_id = $user_query->toArray()['id'];

            $images = explode("~-~", $property['img_urls']);

            return view('property', ['property' => $property, 'phone' => $phone, 'user' => $user_id, 'images' => $images]);
        } else {
            echo "Invalid ID";
            exit;
        }
    }

    public function generate_search_query($data, $not_user = null, $after_date = null) {
        
        $query = Property::query();

        
        $query = $query->select('id', 'street', 'district', 'city', 'postal', 'cost', 'type', 'bath', 'bed', 'size', 'description', 'img_urls', 'lat', 'lng');


        if (!empty($data['bath'])){
            $query = $query->where('bath', '>=', $data['bath']);
        }

        if (!empty($data['bed'])){
            $query = $query->where('bed', '>=', $data['bed']);
        }

        if (!empty($data['min'])){
            $query = $query->where('cost', '>=', $data['min']);
        }


        if (!empty($data['max'])){
            $query = $query->where('cost', '<=', $data['max']);
        }

        if (!empty($data['district'])){
            $query = $query->where('district', 'LIKE', $data['district']);
        }

        if (!empty($data['city'])){
            $query = $query->where('city', 'LIKE', $data['city']);
        }

        if (!empty($data['postal'])){
            $query = $query->where('postal', 'LIKE', $data['postal']);
        }

        if (!empty($data['property_type'])){
            $query = $query->where('type', 'LIKE', $data['property_type']);
        }

        if ($not_user) {
            $query = $query->where('user', '!=', $not_user);
        }

        if ($after_date) {
            $query = $query->where('created_at', '>=', $after_date);
        }

        if (!empty($data['layer_type'])) {
            if ($data['layer_type'] === 'circle') {
                $lat = explode(",", $data['coords'])[0];
                $lng = explode(",", $data['coords'])[1];
                $distance = explode(",", $data['coords'])[2];
                
                $query = $query->selectRaw("( 6371 * acos ( cos ( radians({$lat}) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin ( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance");
                $query = $query->having("distance", "<=", $distance);
            } else {
                $polygon = "'POLYGON(({$data['coords']}))'";
                $query = $query->whereRaw("Contains( GeomFromText({$polygon}), loc )");
            }
        }

        $query = $query->orderBy('id', 'DESC');

        return $query;
    }

    public function search(Request $request)
    {

        $data = [];
        $data['bath'] = $request->bath;
        $data['bed'] = $request->bed;
        $data['min'] = $request->min;
        $data['max'] = $request->max;
        $data['district'] = $request->district;
        $data['city'] = $request->city;
        $data['postal'] = $request->postal;
        $data['property_type'] = $request->property_type;
        $data['layer_type'] = $request->layer_type;
        $data['coords'] = $request->coords;

        $query = $this->generate_search_query($data);
        
        $results = [];

        foreach($query->get()->toArray() as $listing) {
            $r = [];
            $r['id'] = $listing['id'];
            $r['title'] = $listing['street'].", ".$listing['city'].", ".$listing['district']." ".$listing['postal'];
            $r['type'] = $listing['type'];
            $r['bath'] = $listing['bath'];
            $r['bed'] = $listing['bed'];
            $r['size'] = $listing['size'];
            $r['lat'] = $listing['lat'];
            $r['long'] = $listing['lng'];
            $r['cost'] = $listing['cost'];
            $r['img'] = explode("~-~", $listing['img_urls'])[0];
            array_push($results, $r);
        }

        return response()->json(['results' => $results, 'sql' => $query->toSql()]);
    }


    public function file(Request $request)
    {

        $file_array = [];

        if ($request->file('file')) {

            foreach ($request->file('file') as $file) {

                $extension = $file->getClientOriginalExtension();
                
                $supported_extensions = ['jpg', 'png', 'jpeg'];

                if (!in_array($extension, $supported_extensions)) {
                    
                    return response()->json([
                        "success" => false,
                        "message" => "Only jpg, png, jpeg are allowed"
                    ]);
                }
                
                $file = $file->store('public/images');

                $file = str_replace("public/", "/storage/", $file);
                array_push($file_array, $file);
            }

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "file" => $file_array
            ]);
        }
    }

    public function email(Request $request) {


        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'message' => 'required'
        ]);

        $validated = $validator->validated();

        if ($validator->fails()) {
            Session::flash('message', 'All of the fields are required');
            Session::flash('icon', 'error');
            if (empty($validated['id'])) {
                return redirect('/');
            } else {
                return redirect("/property/{$validated['id']}");
            }
        }

        $id = $validated['id'];
        $query = Property::query();

        $user = $query->select('user')->where('id', '=', $id)->first()->toArray()['user'];
                        

        $user_query = User::query();
        $to_email = $user_query->select('email')->where('id', '=', $user)->first()->toArray()['email'];

        
        $name = $validated['name'];
        $email = $validated['email'];
        $phone = $validated['phone'];
        $url = url("/property/{$id}");

        $subject = $name." has sent you an email for your listing";

        $message = $validated['name']." has sent you an email for your <a href='{$url}'>property</a><br>";
        $message .= "Sender's phone number : {$phone}<br>";
        $message .= "<b>Message : </b>".$validated['message'];


        $headers = "From: " . strip_tags($email) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($email) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";



        $check = mail($to_email, $subject,$message, $headers);

        if ($check) {
            Session::flash('message', 'Email Sent!');
            Session::flash('icon', 'success');
            return redirect($url);
        } else {
            Session::flash('message', 'Email could not be sent!');
            Session::flash('icon', 'danger');
            return redirect($url);
        }

    }
}
