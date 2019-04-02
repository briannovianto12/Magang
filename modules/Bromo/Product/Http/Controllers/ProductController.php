<?php

namespace Bromo\Product\Http\Controllers;

use Bromo\Product\DataTables\ProductApprovedDatatable;
use Bromo\Product\DataTables\ProductRejectedDatatable;
use Bromo\Product\DataTables\ProductSubmitedDatatable;
use Bromo\Product\Models\Product;
use Bromo\Product\Models\ProductStatus;
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
}
