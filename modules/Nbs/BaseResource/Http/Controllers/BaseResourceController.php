<?php

namespace Nbs\BaseResource\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nbs\BaseResource\DataTables\BaseResourceDataTable;

abstract class BaseResourceController extends Controller
{
    public $pageData;

    protected $page;

    protected $model;

    protected $title;

    protected $module;

    protected $dataTable;

    protected $requiredData = [];

    protected $validateStoreRules = []; // validate rules on Store method

    protected $validateStoreMessages = []; // validate messages on Store method

    protected $validateUpdateRules = []; // validate rules on Update method

    protected $validateUpdateMessages = []; // validate messages on Update method

    private $browseView;

    private $editorView;

    private $detailView;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->pageData['module'] = $this->module;
        $this->pageData['page'] = $this->page;
        $this->pageData['title'] = $this->title;
    }

    /**
     * Display a listing of the resource.
     *
     * @param BaseResourceDataTable $baseDataTable
     * @return \Illuminate\Http\Response
     */
    public function index(BaseResourceDataTable $baseDataTable)
    {
        if ($this->getDataTable() == null) {
            $this->setDataTable($baseDataTable);
        }

        return $this->dataTable
            ->with([
                'module' => $this->module,
                'model' => $this->model
            ])
            ->render($this->getBrowseView(), $this->pageData);
    }

    /**
     * Getter Datatable
     * @return mixed
     */
    public function getDataTable()
    {
        return $this->dataTable;
    }

    /**
     * Setter DataTable
     * @param mixed $dataTable
     * @return void
     */
    public function setDataTable($dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * @return string
     */
    public function getBrowseView(): string
    {
        if (view()->exists("{$this->module}::browse")) {
            $this->browseView = "{$this->module}::browse";
        } else {
            $this->browseView = "theme::layouts.browse";
        }

        return $this->browseView;
    }

    /**
     * @return string
     */
    public function getDetailView(): string
    {
        if (view()->exists("{$this->module}::detail")) {
            $this->detailView = "{$this->module}::detail";
        } else {
            $this->detailView = "theme::layouts.detail";
        }

        return $this->detailView;
    }

    /**
     * Show the form to create a Resource
     *
     * @return mixed
     */
    public function create()
    {
        $data = $this->getRequiredData();

        return view($this->getEditorView(), $this->pageData, $data);
    }

    /**
     * Additional Data
     * @return mixed
     */
    private function getRequiredData()
    {
        return $this->requiredData;
    }

    private function getEditorView(): string
    {
        if (view()->exists("{$this->module}::editor")) {
            $this->editorView = "{$this->module}::editor";
        } else {
            $this->editorView = "theme::layouts.editor";
        }

        return $this->editorView;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $inputData = $this->validate($request, $this->validateStoreRules, $this->validateStoreMessages);

        DB::beginTransaction();
        try {
            $attributes = $this->modifyWhenStore($inputData, $request);
            $this->performStore($request, $attributes);
            nbs_helper()->flashMessage('stored');
            DB::commit();
        } catch (\Exception $exception) {
            nbs_helper()->flashError('Something wen\'t wrong. Please contact Administrator');
            DB::rollBack();
            dd($exception);
        }


        return redirect()->route($this->module);
    }

    /**
     * Perform after Store
     * @param Request $request
     * @param $attributes
     * @return void
     */
    protected function performStore(Request $request, $attributes)
    {
        $this->model->create($attributes);
    }

    /**
     * Perform after Update
     * @param Request $request
     * @param $id
     * @param $attributes
     */
    protected function performUpdate(Request $request, $id, $attributes)
    {
        $this->model->updateOrCreate(['id' => $id], $attributes);
    }

    /**
     * Perform after Delete
     * @param Request $request
     * @param $data
     */
    protected function performAfterDelete(Request $request, $data)
    {
        //
    }

    /**
     * Modify input data then send data to store method
     * @param array $inputData
     * @param Request $request
     * @return array
     */
    protected function modifyWhenStore(array $inputData, Request $request): array
    {
        return array_merge($inputData, $request->only($this->validateStoreRules));
    }

    public function edit($id)
    {
        $this->pageData['data'] = $this->model->findOrFail($id);
        $data = array_merge($this->pageData, $this->getRequiredData());

        return view($this->getEditorView(), $data);
    }

    public function show($id)
    {
        $this->pageData['data'] = $this->model->findOrFail($id);
        $data = array_merge($this->pageData, $this->getRequiredData());

        return view($this->getDetailView(), $data);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $inputData = $this->validate($request, $this->validateUpdateRules, $this->validateUpdateMessages);
        $attributes = $this->modifyWhenUpdate($inputData, $request);
        $this->performUpdate($request, $id, $attributes);
        nbs_helper()->flashMessage('updated');

        return redirect()->route($this->module);
    }

    /**
     * Modify input data then send data to update method
     * @param array $inputData
     * @param Request $request
     * @return array
     */
    protected function modifyWhenUpdate(array $inputData, Request $request): array
    {
        return array_merge($inputData, $request->only($this->validateUpdateRules));
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $this->modelDestroy($id);
        });

        return response()->json(['success' => true]);
    }

    protected function modelDestroy($id)
    {
        $data = $this->model->findOrFail($id);
        $data->delete();

        return $data;
    }
}
