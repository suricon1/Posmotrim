@extends('admin.layouts.layout')

@section('header')
    <link rel="stylesheet" href="/css/select2.min.css">
@endsection

@section('title', 'Admin | Редактировать сорт винограда: '.$product->name)
@section('key', 'Admin | Редактировать сорт винограда: '.$product->name)
@section('desc', 'Admin | Редактировать сорт винограда: '.$product->name)

@section('header-title', 'Редактировать сорт винограда: '.$product->name)

@section('content')

    <div class="col">

        {{Form::open([
            'route'	=>	['products.update', $product->id],
            'files'	=>	true,
            'method'	=>	'patch',
            'id' => 'uploadImages',
            'data-redirect' => route('products.index')
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
                        <img src="{{asset($product->getImage('400x400'))}}" id="image_preview" alt="" class="img-responsive" width="200">
                    </div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <label for="exampleInputFile">Загрузить заглавное фото статьи (Размер фото: 600х600 px. Макс. вес - 500Kb)</label>
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
                    <h3 class="card-title"><i class="fa fa-angle-right"></i>Название и мета-данные</h3>
                </button>
            </div>
            <div class="card-body">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Title</span>
                    </div>
                    <input name="meta[title]" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('meta[title]', $product->meta['title'])}}">
                </div>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Название</span>
                    </div>
                    <input name="name" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('name', $product->name)}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Алиас</label>
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text">https://vinograd.posmotrim.loc/product/</span>
                        </div>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="slug" value="{{old('slug', $product->slug)}}">
                        <div class="input-group-append">
                            <span class="input-group-text">.html</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Описание (description)</label>
                            <textarea name="meta[desc]" class="form-control" rows="3" placeholder="Мета-описание ...">{{old('meta[desc]', $product->meta['description'])}}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ключевые слова (keywords)</label>
                            <textarea name="meta[key]" class="form-control" rows="3" placeholder="Ключевые слова ...">{{old('meta[key]', $product->meta['keywords'])}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-default collapsed-card">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-widget="collapse">
                    <h3 class="card-title"><i class="right fa fa-angle-right"></i>Категория - характеристики - модификации</h3>
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Категория</label>
                            {{Form::select('category_id',
                                $categorys,
                                $product->getCategoryID(),
                                [
                                    'class' => 'form-control select2',
                                    'style' => 'width: 100%',
                                    'id' => 'category'
                                ])
                            }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Селекционер</label>
                            {{Form::select('selection_id',
                                $selections,
                                $product->selection_id,
                                [
                                    'class' => 'form-control select2',
                                    'style' => 'width: 100%',
                                    'id' => 'selection'
                                ])
                            }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Страна селекции</label>
                            {{Form::select('country_id',
                                $countrys,
                                $product->country_id,
                                [
                                    'class' => 'form-control select2',
                                    'style' => 'width: 100%',
                                    'id' => 'country'
                                ])
                            }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('is_featured', '1', $product->is_featured, ['class'=>'minimal'])}}
                            </label>
                            <label>
                                Рекомендовать
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                {{Form::checkbox('status', '1', $product->status, ['class'=>'minimal'])}}
                            </label>
                            <label>
                                Черновик
                            </label>
                        </div>
                    </div>
                </div>
                {{--<hr>--}}
                <div class="row">
                    <div class="col-xl-6">
                        <hr>
                        <label>Основные характеристики</label>
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Срок созревания</span>
                            </div>
                            {{Form::select('ripening',
                                ripeningProducts(),
                                old('ripening', $product->ripening),
                                [
                                    'class' => 'custom-select',
                                    'id' => 'inputGroup-sizing-sm',
                                    'placeholder' => 'Выбрать срок созревания'
                                ])
                            }}
{{--                            <input name="ripening" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('ripening', $product->ripening)}}">--}}
                            <div class="input-group-append">
                                <span class="input-group-text">дней</span>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Средняя масса грозди</span>
                            </div>
                            <input name="props[mass]" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('props[mass]', $product->props['mass'])}}">
                            <div class="input-group-append">
                                <span class="input-group-text">грамм</span>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Окраска</span>
                            </div>
                            <input name="props[color]" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('props[color]', $product->props['color'])}}">
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Вкус</span>
                            </div>
                            <input name="props[flavor]" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('props[flavor]', $product->props['flavor'])}}">
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Морозоустойчивость</span>
                            </div>
                            <input name="props[frost]" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('props[frost]', $product->props['frost'])}}">
                            <div class="input-group-append">
                                <span class="input-group-text">&#8451;</span>
                            </div>
                        </div>
                        <div class="input-group input-group-sm mb-2">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroup-sizing-sm">Цветок</span>
                            </div>
                            <input name="props[flower]" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{old('props[flower]', $product->props['flower'])}}">
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <hr>
                        <div class="modification">
                            <label>Модификации:</label>
                            @foreach($product->adminModifications as $modification)
                                @include('admin.vinograd.product._modification-input-item', ['modification' => $modification])
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modificationModal">Добавить модификацию</button>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Похожие сорта</label>
                            {{Form::select('props[similar][]',
                              $productsAll,
                              old('props[similar]', (array_key_exists('similar', $product->props)) ? $product->props['similar'] : null),
                              [
                                  'class' => 'form-control select2',
                                  'multiple'=>'multiple',
                                  'data-placeholder'=>'Выбрать похожие сорта',
                                  'style' => 'width: 100%'
                              ])
                            }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-default collapsed-card">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-widget="collapse">
                    <h3 class="card-title"><i class="fa fa-angle-right"></i>Галерея</h3>
                </button>
            </div>
            <div class="card-body">

{{--                @if($product->galery)--}}
                <div class="card-deck">
{{--                    {{dd($product->getGallery('400x400'))}}--}}
                    @foreach($product->getGallery('400x400') as $image)
                        <div class="card" style="max-width: 18rem;">
                            <img width="100" class="card-img-top" src="{{asset(Storage::url($image))}}">
                            <div class="card-body">
                                <div class="custom-control custom-checkbox">
                                    <input name="removeGallery[]" value="{{class_basename($image)}}" type="checkbox" class="custom-control-input" id="{{$loop->iteration}}">
                                    <label class="custom-control-label" for="{{$loop->iteration}}">Удалить</label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{--@endif--}}

                <div class="form-group">
                    <label for="exampleInputFile">Загрузить фото в галерею (Размер фото: 600х600 px. Макс. вес - 500Kb)</label>
                    <div class="input-group">
                        <div class="custom-file">
                            {{Form::file('gallery[]', ['multiple'=>true, 'accept'=>'image/*', 'class'=>'custom-file-input', 'id'=>'exampleGallery'])}}
                            <label class="custom-file-label" for="exampleGallery">Выберите фото</label>
                        </div>
                    </div>
                    <div>
                        <ul id="uploadImagesList">
                            <li class="item template">
                                <span class="img-wrap">
                                    <img src="" alt="">
                                </span>
                                <span class="delete-link" title="Удалить">Удалить</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="dropped-files"></div>

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
                    <label for="exampleInputEmail1">Полный текст</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{old('content', $product->content)}}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Антонация</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{old('description', $product->description)}}</textarea>
                </div>
            </div>
        </div>

        <button class="btn btn-warning mb-3">Изменить</button>

        {{Form::close()}}
    </div>
    @include('components.add-modification', ['productId' => $product->id])

@endsection

@section('scripts')
    <script src="/js/multiUploadViewt.js" ></script>
    <script src="/js/select2.full.min.js"></script>

    <script src="/js/ckeditor/ckeditor.js"></script>
    <script>
        var editor = CKEDITOR.replace('content');
        editor.config.height = '400px';
        // CKFinder.setupCKEditor( editor );
        var editor2 = CKEDITOR.replace('description');

        $('.select2').select2();
    </script>
@endsection
