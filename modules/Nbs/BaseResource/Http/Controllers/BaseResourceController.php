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
//        $this->middleware('admin');
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
        if (view()->exists("{$this->module}::{$this->module}.browse")) {
            $this->browseView = "{$this->module}::{$this->module}.browse";
        } else {
            $this->browseView = "theme::layouts.browse";
        }

        return $this->browseView;
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
        if (view()->exists("{$this->module}::{$this->module}.editor")) {
            $this->editorView = "{$this->module}::{$this->module}.editor";
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
        $this->model->create($this->modifyWhenStore($inputData));

        nbs_helper()->flashMessage('stored');

        return redirect()->route("{$this->module}.index");
    }

    /**
     * Modify input data then send data to store method
     * @param array $inputData
     * @return array
     */
    protected function modifyWhenStore(array $inputData): array
    {
        return $inputData;
    }

    public function edit($id)
    {
        $this->pageData['data'] = $this->model->findOrFail($id);
        $data = array_merge($this->pageData, $this->getRequiredData());

        return view($this->getEditorView(), $data);
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
        $this->model->updateOrCreate(['id' => $id], $this->modifyWhenStore($inputData));

        nbs_helper()->flashMessage('updated');

        return redirect()->route("{$this->module}.index");
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

    /**
     * Modify input data then send data to update method
     * @param array $inputData
     * @return array
     */
    protected function modifyWhenUpdate(array $inputData): array
    {
        return $inputData;
    }
}
