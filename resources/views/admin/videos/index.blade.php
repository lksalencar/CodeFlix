@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Listagem de vídeos</h3>
            {!! Button::primary('Novo vídeo')->asLinkTo(route('admin.videos.create')) !!}
        </div>
        <div class="row">
            {!!
               Table::withContents($videos->items())->striped()->bordered()
               ->callback('Descrição', function ($field, $video){
                 return MediaObject::withContents(
                      [
                      'image' => $video->thumb_small_asset,
                       'link' => $video->file_asset,
                       'heading' => $video->title,
                       'body' => $video->description
                      ]
                 );
                 })->callback('Ações', function ($field, $video){
                  $linkEdit = route('admin.videos.edit',['video' => $video->id]);
                  $linkShow = route('admin.videos.show',['video' => $video->id]);
                  return Button::link(Icon::create('pencil'))->asLinkTo($linkEdit).'|'.
                              Button::link(Icon::create('remove'))->asLinkTo($linkShow);
               })
            !!}
        </div>
        {!! $videos->Links() !!}
    </div>
@endsection

@push('styles')
<style type="text/css">
    .media-body {
        width: 400px;
    }
</style>
@endpush


