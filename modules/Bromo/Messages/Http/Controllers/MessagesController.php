<?php

namespace Bromo\Messages\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Nbs\BaseResource\Http\Controllers\BaseResourceController;
use Bromo\Messages\Entities\Message;

class MessagesController extends BaseResourceController
{
    const PAGE_SIZE = 30;

    public function __construct(Message $model)
    {
        $this->module = 'messages';
        $this->page = 'Messages';
        $this->title = 'Messages';
        $this->model = $model;
        parent::__construct();
    }
    

    public function searchList(Request $request) {

        $searchVal = $request->get('search', "");

        $query = $this->model
            ->selectRaw( \DB::raw(" B.name as sender,
            G.full_name as sender_name, G.msisdn as sender_phone,
            C.name as receiver, 
            E.full_name as receiver_name, E.msisdn as receiver_phone,
            message, to_char(messages.created_at,'YYYY-MM-DD HH24:MI:SS') as time,
            H.name as sender_shop_name, I.name as receiver_shop_name 
            ") )
            ->leftJoin('business as b','messages.business_sender_id','=','b.id')
            ->leftJoin('business as c','messages.business_receiver_id','=','c.id')
            ->leftJoin('business_member as d','c.id','=','d.business_id')
            ->leftJoin('user_profile as e','d.user_id','=','e.id')
            ->leftJoin('business_member as f','b.id','=','f.business_id')
            ->leftJoin('user_profile as g','f.user_id','=','g.id')
            ->leftJoin('shop as h','b.id','=','h.business_id')
            ->leftJoin('shop as i','c.id','=','i.business_id');

        if(!empty($searchVal)) {
            $query->whereRaw("B.name ilike '%".$searchVal."%'")
                ->orWhereRaw("G.msisdn ilike '%".$searchVal."%'")
                ->orWhereRaw("G.full_name ilike '%".$searchVal."%'")
                ->orWhereRaw("C.name ilike '%".$searchVal."%'")
                ->orWhereRaw("E.msisdn ilike '%".$searchVal."%'")
                ->orWhereRaw("E.full_name ilike '%".$searchVal."%'");
        }

        $results = $query->orderBy('messages.created_at','desc')
            ->simplePaginate(self::PAGE_SIZE)
            ->appends(['search'=>$searchVal]);
        
        return view("messages::index", [
            'title' => $this->title,
            'module' => $this->module,
            'page' => $this->page,
            'results' => $results,
            'search_keyword' => $searchVal,
        ]);
    }
}
