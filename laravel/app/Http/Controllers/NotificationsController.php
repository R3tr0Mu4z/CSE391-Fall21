<?php

namespace App\Http\Controllers;

use App\Models\SavedSearch;
use App\Models\Notification;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
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

        $this->check_notification();

        $user = Auth::user()->id;

        $notifications = Notification::leftJoin('properties', 'properties.id', '=', 'notifications.property')
            ->leftJoin('saved_searches', 'saved_searches.id', '=', 'notifications.saved_search')
            ->select(['notifications.id as notification_id', 'properties.id as property_id', 'saved_searches.id as saved_id', 'saved_searches.save_search_name as saved_name', 'properties.street', 'properties.city', 'properties.district', 'properties.postal', 'properties.created_at as time_added', 'notifications.seen', 'properties.img_urls'])
            ->where('notifications.user', '=', $user)
            ->orderBy('notifications.id', 'DESC');

        $before_seen = $notifications->get()->toArray();
        
        $data = [];
        $data['seen'] = 1;

        $notifications->update($data);

        

        return view('notifications', ['notifications' => $before_seen]);
    }
    

    public function check_notification()
    {
        $user = Auth::user()->id;

        $saved_searches = SavedSearch::select('*')->where('user', $user)->get()->toArray();

        $unseen = 0;
        $new = [];


        if (!empty($saved_searches)) {
            foreach ($saved_searches as $saved_search) {

                $properties = PropertyController::generate_search_query($saved_search, $user, $saved_search['updated_at']);


                if ($properties->get()->count() > 0) {
                    foreach ($properties->get()->toArray() as $property) {
                        $notification = new Notification();

                        $notification->property = $property['id'];
                        $notification->user = $user;
                        $notification->saved_search = $saved_search['id'];
                        $notification->seen = 0;
                        $notification->save();

                        $prop = [];
                        $prop['save_id'] = $saved_search['id'];
                        $prop['id'] = $property['id'];
                        $prop['title'] = $property['street'].", ".$property['city'].", ".$property['district']." ".$property['postal'];
                        $prop['img'] = explode("~-~", $property['img_urls'])[0];
                        $prop['saved_search_name'] = $saved_search['save_search_name'];

                        array_push($new, $prop);
                    }
                }
                SavedSearch::where('id', $saved_search['id'])
                    ->where('user', Auth::user()->id)
                    ->update([]);
            }

            $unseen = Notification::select("id")->where('user', '=', $user)->where('seen', '=', 0)->count();

        }

        return response()->json(['unseen' => $unseen, 'new' => $new]);
    }
}
