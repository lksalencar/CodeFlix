@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Ver vídeo</h3>
                <?php $iconEdit = Icon::create('pencil'); ?>
                    {!! Button::primary($iconEdit)->asLinkTo(route('admin.videos.edit',['video' => $videos->id])) !!}
                <?php $iconDestroy = Icon::create('remove'); ?>
                    {!! Button::danger($iconDestroy)
                    ->asLinkTo(route('admin.videos.destroy',['video' => $videos->id]))
                    ->addAttributes(['onclick' => "event.preventDefault();document.getElementById(\"form-delete\").submit()"])
                    !!}
                <?php
                     $formDelete = FormBuilder::plain([
                        'id' => 'form-delete',
                        'route' => ['admin.videos.destroy', 'video' => $videos->id],
                            'method' => 'DELETE',
                             'style' => 'display:none'
                     ])
                ?>
                 {!! form($formDelete) !!}
                <br><br>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th scope="row">#</th>
                            <td>{{$videos->id}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Título</th>
                            <td>{{$videos->title}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Descrição</th>
                            <td>{{$videos->description}}</td>
                        </tr>
                    </tbody>
                </table>
        </div>
    </div>
@endsection



