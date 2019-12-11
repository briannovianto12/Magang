<?php

namespace Bromo\FreqAskedQuestion\Http\Controllers;

use Bromo\FreqAskedQuestion\Models\FreqAskedQuestion;
use Bromo\FreqAskedQuestion\Models\FAQCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class FAQCategoryController extends Controller
{

    public function __construct(FAQCategory $model)
    {
        $this->model = $model;
        $this->module = 'faq-category';
        $this->title = ucwords($this->module);
    }
   
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['faq_category_list'] = FAQCategory::select()->get();
        return view('freqaskedquestion::index-category', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('freqaskedquestion::create-category');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $faqCategory = new FAQCategory();
        $faqCategory->name = $request->input('name');
        $faqCategory->save();
        return redirect()->route('faq.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //TO DO
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //TO DO
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //Update 
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        FAQCategory::destroy($id);

        return redirect()->route('faq-category.index');
    }
}
