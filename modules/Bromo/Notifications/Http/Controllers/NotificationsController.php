<?php

namespace Bromo\Notifications\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Bromo\Notifications\Events\NewsNotificationByTopic;
use Bromo\Notifications\Entities\NewsNotification;
use Validator;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('notifications::index');
    }

    /**
     * Send newly created resource to an event.
     * @param Request $request
     * @return Response
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required',
            'title' => 'required|max:40',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('notifications')
                        ->withErrors($validator)
                        ->withInput();
        }

        $data = [
            'topic' => $request->topic,
            'title' => $request->title,
            'body' => $request->body,
        ];

        $notification = new NewsNotification;
        $notification->topic = $request->topic;
        $notification->title = $request->title;
        $notification->body = $request->body;
        $notification->save();
        
        try{
            event(new NewsNotificationByTopic($data));
            return back()->with('successMsg', 'Success!');
        }catch (Exception $exception){
            return back()->with('warningMsg', 'Message has been requested, it will reached the recipient soon!');
        }

        // return back()->with('successMsg', 'Success!');
    }

}
