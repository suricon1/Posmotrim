@extends('admin.layouts.layout')

@section('header')
    <link rel="stylesheet" href="/css/select2.min.css">
@endsection

@section('title', 'Admin | Редактировать пост')
@section('key', 'Admin | Редактировать пост')
@section('desc', 'Admin | Редактировать пост')

@section('header-title', 'Редактировать пост')

@section('content')

    <div class="col">

        {{Form::open([
            'route'	=>	['posts.update', $post->id],
            'files'	=>	true,
            'method'	=>	'put'
        ])}}

        <div class="card card-default collapsed-card">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-widget="collapse">
                    <h3 class="card-title"><i class="fa fa-angle-right"></i>Заглавное фото</h3>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3"  id="error_img">
                        <img src="{{ asset($post->getImage('220x165')) }}" id="image_preview" alt="" class="img-responsive" width="200">
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="exampleInputFile">Загрузить заглавное фото статьи (Максимальные размеры фото: 900х600 и весом не более 500KB)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="image">
                                    <label class="custom-file-label" for="exampleInputFile">Выберите фото</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-default collapsed-card">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-widget="collapse">
                    <h3 class="card-title"><i class="fa fa-angle-right"></i>Название мета-данные статусы</h3>
                </button>
            </div>
            <div class="card-body">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Title</span>
                    </div>
                    <input name="meta[title]" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('meta[title]', $post->meta['title'])}}">
                </div>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Название</span>
                    </div>
                    <input name="name" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('name', $post->name)}}">
                </div>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Алиас</span>
                    </div>
                    <input name="slug" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('slug', $post->slug)}}">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Описание (description)</label>
                            <textarea name="meta[desc]" class="form-control" rows="3" placeholder="Мета-описание ...">{{old('meta[desc]', $post->meta['description'])}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ключевые слова (keywords)</label>
                            <textarea name="meta[key]" class="form-control" rows="3" placeholder="Ключевые слова ...">{{old('meta[key]', $post->meta['keywords'])}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Категория</label>
                            {{Form::select('category_id',
                                $categorys,
                                $post->category_id,
                                [
                                    'class' => 'form-control select2',
                                    'style' => 'width: 100%',
                                    'id' => 'category'
                                ])
                            }}
                        </div>
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('status', '1', $post->status, ['class'=>'minimal'])}}
                            </label>
                            <label>
                                Черновик
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Теги</label>
                            {{Form::select('tags[]',
                              $tags,
                              null,
                              [
                                  'class' => 'form-control select2',
                                  'multiple'=>'multiple',
                                  'data-placeholder'=>'Выберите теги',
                                  'style' => 'width: 100%'
                              ])
                            }}
                        </div>
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('featured', '1', $post->featured, ['class'=>'minimal'])}}
                            </label>
                            <label>
                                Рекомендовать
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-default">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-widget="collapse">
                    <h3 class="card-title"><i class="fa fa-angle-right"></i>Текст статьи и Антонация</h3>
                </button>
            </div>
            <div class="card-body">
                <div class="form-group" id="editor">
                    <label for="exampleInputEmail1">Полный текст <span class="text-danger">*</span></label>
                    <textarea name="content" id="content">{{old('content', $post->content)}}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Антонация</label>
                    <textarea name="description" id="description">{{old('description', $post->description)}}</textarea>
                </div>
            </div>
        </div>

        <button class="btn btn-warning mb-3">Изменить</button>

        {{Form::close()}}
    </div>
@endsection

@section('scripts')
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/js/select2.full.min.js"></script>
    <script>
        var editor = CKEDITOR.replace('content');
        editor.config.height = '600px';
        var editor2 = CKEDITOR.replace('description');

        $('.select2').select2();
    </script>
@endsection
