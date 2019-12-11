<?php

namespace Bromo\FreqAskedQuestion\Http\Controllers;

use Bromo\FreqAskedQuestion\Models\FreqAskedQuestion;
use Bromo\FreqAskedQuestion\Models\FAQCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Image;
use Exception;
use DB;

class FreqAskedQuestionController extends Controller
{

    public function __construct(FreqAskedQuestion $model)
    {
        $this->model = $model;
        $this->module = 'faq';
        $this->title = ucwords($this->module);
    }
   
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data['faq_list'] = FreqAskedQuestion::select()->get();
        return view('freqaskedquestion::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $data['categories'] = FAQCategory::select()->get();
        return view('freqaskedquestion::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $path = '/faq/';
        $faq = new FreqAskedQuestion();
        $faq->title = $request->input('title');
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->faq_category = $request->input('category');
        $faq->accessible_by = $request->input('accessibility');
        $faq->is_visible = $request->input('visibility');
        $faq->sort_by = $request->input('sort-by');
        $files = $request->file('attachments');

        $inputTags = json_decode($request->input('input-tags'));
        foreach($inputTags as $key => $inputTag){
            $updatedTags[] = $inputTag->value;
        }
        $faq->tags = $updatedTags;
        
        foreach($files as $file){
            $filenames[] = $file->getClientOriginalName(); 
        }

        json_encode($filenames);
        $faq->attachments = $filenames;
        
        foreach($files as $file){
            $image = Image::make($file);
            $filename = $file->getClientOriginalName();    
            $upload[] = Storage::put($path . $filename, $image->stream(), 'public');
            if ($upload === false) {
                new Exception('Error on upload');
            } 
        }
        $faq->save();

        return redirect()->route('faq.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data['faq'] = FreqAskedQuestion::where('id', $id)->first();
        $attachments = $data['faq']->attachments;
        foreach($attachments as $attachment){
            $images[] = config('freqaskedquestion.gcs_path') . "/" . config('freqaskedquestion.path.faq') . $attachment;
        }
        $data['images'] = $images;
        
        return view('freqaskedquestion::show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $data['faq'] = FreqAskedQuestion::where('id', $id)->first();
        $data['categories'] = FAQCategory::select()->get();

        return view('freqaskedquestion::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $faq = FreqAskedQuestion::where('id', $id)->first();
        $path = '/faq/';
        $faq->title = $request->input('title');
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->faq_category = $request->input('category');
        $faq->accessible_by = $request->input('accessibility');
        $faq->is_visible = $request->input('visibility');
        $faq->sort_by = $request->input('sort-by');
        $files = $request->file('attachments');

        $inputTags = json_decode($request->input('input-tags'));
        foreach($inputTags as $key => $inputTag){
            $updatedTags[] = $inputTag->value;
        }
        $faq->tags = $updatedTags;
        
        if($files != null){
            foreach($files as $file){
                $filenames[] = $file->getClientOriginalName(); 
            }  

            json_encode($filenames);
            $faq->attachments = $filenames;

            foreach($files as $file){
                $image = Image::make($file);
                $filename = $file->getClientOriginalName();    
                $upload[] = Storage::put($path . $filename, $image->stream());
                if ($upload === false) {
                    new Exception('Error on upload');
                } 
            }
        }
        
        $faq->save();

        return redirect()->route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        FreqAskedQuestion::destroy($id);

        return redirect()->route('faq.index');
    }
}
