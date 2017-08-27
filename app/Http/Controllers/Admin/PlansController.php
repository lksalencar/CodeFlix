<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\PlanForm;
use CodeFlix\Models\Plan;
use CodeFlix\Repositories\PlanRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;

class PlansController extends Controller
{
    /**
     * @var PlanRepository
     */
    private $repository;

    /**
     * PlansController constructor.
     * @param PlanRepository $repository
     */
    public function __construct(PlanRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = $this->repository->paginate();
        return view('admin.plans.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = \FormBuilder::create(PlanForm::class, [
            'url' => route('admin.plans.store'),
            'method' => 'POST'
        ]);
        return view('admin.plans.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var Form $form */
        $form = \FormBuilder::create(PlanForm::class);

        if(!$form->isValid()){
            //redirecionar para a página de criação de usuários
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();

        }
        $data = $form->getFieldValues();
        $this->repository->create(array_except($data,'code'));
        $request->session()->flash('message', 'Plano criado com sucesso!');
        return redirect()->route('admin.plans.index');
    }

    /**
     * Display the specified resource.
     * @param Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return view('admin.plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Plan $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $form = \FormBuilder::create(PlanForm::class, [
            'url' => route('admin.plans.update', ['plan' => $plan->id]),
            'method' => 'PUT',
            'model' => $plan
        ]);
        return view('admin.plans.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var Form $form */
        $form = \FormBuilder::create(PlanForm::class);

        if(!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();

        }
        $data = $form->getFieldValues();
        $this->repository->update($data, $id);
        $request->session()->flash('message', 'Plano alterado com sucesso!');
        return redirect()->route('admin.plans.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,$id)
    {
        $this->repository->delete($id);
        $request->session()->flash('message', 'Plano excluido com sucesso!');
        return redirect()->route('admin.plans.index');
    }

}
