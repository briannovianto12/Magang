<?php

namespace Bromo\Product\Http\Controllers;

use Bromo\Product\DataTables\ProductApprovedDatatable;
use Bromo\Product\DataTables\ProductRejectedDatatable;
use Bromo\Product\DataTables\ProductSubmitedDatatable;
use Bromo\Product\Models\Product;
use Bromo\Product\Models\ProductStatus;
use Bromo\ProductCategory\Models\ProductCategory;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
{

    protected $module;
    protected $model;
    protected $title;

    /**
     * Create a new controller instance.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
        $this->module = 'product';
        $this->title = ucwords($this->module);
        $this->middleware('auth');
    }

    /**
     * Display index page.
     *
     * @return Factory|View
     */
    public function index()
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;

        return view("{$this->module}::list", $data);
    }


    /**
     * Get the submited data.
     *
     * @param ProductSubmitedDatatable $datatable
     * @return mixed
     */
    public function submited(ProductSubmitedDatatable $datatable)
    {
        return $datatable
            ->with([
                'model' => $this->model,
                'module' => $this->module,
            ])
            ->render("$this->module::list");
    }

    /**
     * Get the rejected data.
     *
     * @param ProductRejectedDatatable $datatable
     * @return mixed
     */
    public function rejected(ProductRejectedDatatable $datatable)
    {
        return $datatable
            ->with([
                'model' => $this->model,
                'module' => $this->module,
            ])
            ->render("$this->module::list");
    }

    /**
     * Get the approved data.
     *
     * @param ProductApprovedDatatable $datatable
     * @return mixed
     */
    public function approved(ProductApprovedDatatable $datatable)
    {
        return $datatable
            ->with([
                'model' => $this->model,
                'module' => $this->module,
            ])
            ->render("$this->module::list");
    }

    /**
     * Get the detail of product.
     *
     * @param $id
     * @return Factory|View
     */
    public function show($id)
    {
        $data['module'] = $this->module;
        $data['title'] = $this->title;
        $data['data'] = Product::findOrFail($id);

        return view("{$this->module}::detail", $data);
    }

    /**
     * Verified product.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function verified($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);

            $product->update([
                'status' => ProductStatus::PUBLISH
            ]);
            $product->increment('version', 1);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }

        return redirect()->back();
    }

    /**
     * Unverified product.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function unverified(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            $product->update([
                'status' => ProductStatus::REJECT
            ]);
            $product->productStatusNote()->create([
                'product_snapshot' => $product,
                'notes' => $request->input('notes'),
                'status' => ProductStatus::REJECT
            ]);
            $product->increment('version', 1);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }

        return redirect()->back();
    }

    public function status($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
            $product->update([
                'status' => ($product->status === ProductStatus::PUBLISH) ? ProductStatus::UNPUBLISH : ProductStatus::PUBLISH
            ]);

            DB::commit();
            nbs_helper()->flashMessage('stored');

        } catch (Exception $exception) {
            report($exception);
            DB::rollBack();

            nbs_helper()->flashMessage('error');
        }

        return redirect()->back();
    }

    /**
     * edit product.
     *
     * @param $id
     * @return RedirectResponse
     */
    public function updateCategory(Request $request, $id)
    {
        if ( isset($request->fourthcategory)  ) {
            $category_id = $request->fourthcategory;
        } else if ( isset($request->thirdcategory) ) {
            $category_id = $request->thirdcategory;
        } else if ( isset($request->secondcategory) ) {
            $category_id = $request->secondcategory;
        } else if ( isset($request->maincategory) ) {
            $category_id = $request->maincategory;
        }

        $category = ProductCategory::findOrFail($category_id);

        \Log::debug($category->name);
        if($this->hasChild($category_id)){
            // Error belum leaf category
            return response()->json([
                "status" => "Failed",
                "category" => $category->name,
            ]);
        }

        $product = Product::findOrFail($id);
        $product->category_id = $category->id;
        $product->category = $category->name;

        $product->save();
        \Log::debug($product);

        return response()->json([
            "status" => "OK",
            "nama_produk" => $product->name,
        ]);
    }

    public function getProductInfo(Request $request, $id) {
        $product = Product::find($id);
        $product_image_array = $product->image_files['filenames'];
        if(count($product_image_array) > 0) {
            $image = config('product.gcs_path') . "/" .  config('product.path.product')  .  $product_image_array[0];            
        }

        $current_category = DB::select("SELECT f_get_category_fulltext($product->category_id)");
        $weight = $product->dimensions['after_packaging']['weight'];

        return response()->json([
            "data" => $product,
            "items" => $image,
            "current_category" => $current_category[0]->f_get_category_fulltext,
            "weight" => $weight,
        ]);
    }

    public function getProductCategory( $id = null ) {

        if ( $id == null ) {
            $categories = ProductCategory::select('id','name')->where('level', 1)->orderBy('sort_by')->get();
        } else {
            $categories = ProductCategory::select('id','name')->where('parent_id', $id)->orderBy('sort_by')->get();
        }
      
        return response()->json([
            "categories" => $categories,
        ]);
    }

    private function hasChild( $category_id ) {
        $has_child = ProductCategory::where('parent_id', $category_id)->count();
        return $has_child > 0;
    }

    public function updateWeight(Request $request, $id) {
        if ( isset($request->newWeight)  ) {
            $new_weight = $request->newWeight;
        } else {
            return response()->json([
                "status" => "Failed"
            ]);
        }

        // TODO use DB Transaction
        // TODO update product weight log
        $product = Product::findOrFail($id);
        $dimensions = $product->dimensions;
        $dimensions['after_packaging']['weight'] = $new_weight;
        $dimensions['before_packaging']['weight'] = $new_weight;

        $product->dimensions = $dimensions;

        $product->save();

        \Log::debug($product);

        return response()->json([
            "status" => "OK",
            "nama_produk" => $product->name,
        ]);
    }

    public function updateTags(Request $request, $id){

        $product = Product::findOrFail($id);
        $inputTags = json_decode($request->input('input-tags'));
        if(empty($inputTags)){
            return back()->with('errorMsg', 'Tags cannot be empty!');
        } 
        $updatedTags = null;
        foreach($inputTags as $key => $inputTag){
            $updatedTags[] = $inputTag->value;
        }
        //dd($updatedTags);
        $product->tags = $updatedTags;
        $product->save();

        return back()->with('successMsg', 'Update Success!');;
    }
}
