<?php

namespace CodeFlix\Http\Controllers\Admin;

use Illuminate\Http\Request;
use CodeFlix\Http\Requests;
use CodeFlix\Repositories\SubscriptionRepository;


class SubscriptionsController extends Controller
{

    /**
     * @var SubscriptionRepository
     */
    protected $repository;



    public function __construct(SubscriptionRepository $repository)
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

    }

    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }



    public function update()
    {


    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
