<?php

namespace CodeFlix\Http\Controllers\Admin;

use CodeFlix\Forms\VideoUploadForm;
use CodeFlix\Models\Video;
use CodeFlix\Repositories\VideoRepository;
use Illuminate\Http\Request;
use CodeFlix\Http\Controllers\Controller;

class VideoUploadsController extends Controller
{
    private $repository;

    /**
     * VideoRelationsController constructor.
     * @param VideoRepository $repository
     */
    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function create(Video $video)
    {
        $form = \FormBuilder::create(VideoUploadForm::class, [
            'url' => route('admin.videos.uploads.store', ['video' => $video->id]),
            'method' => 'POST',
            'model' => $video
        ]);
        return view('admin.videos.upload', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id)
    {
        $form = \FormBuilder::create(VideoUploadForm::class);
        if (!$form->isValid()){
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }
        if($request->file('thumb')){
            $this->repository->uploadThumb($id,$request->file('thumb'));//l5-repository
        }
        if($request->file('file')){
            $this->repository->uploadFile($id,$request->file('file'));//l5-repository
        }
        $this->repository->update(['duration' => $request->get('duration')], $id);
        $request->session()->flash('message', 'Upload(s) realizado(s) com sucesso.');
        return redirect()->route('admin.videos.uploads.create',['video' => $id]);
    }


}
