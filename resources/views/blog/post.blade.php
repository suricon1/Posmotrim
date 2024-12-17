@extends('layouts.vinograd-left')

@section('title', $post->meta['title'])
@section('key', $post->meta['keywords'])
@section('desc', $post->meta['description'])

@section('breadcrumb-content')
    <li><a href="{{route('blog.home')}}">Блог</a></li>
    <li><a href="{{route('blog.category', ['slug' => $post->category->slug])}}">{{$post->category->title}}</a></li>
    <li class="active">{{$post->name}}</li>
@endsection

@section('section-title')
    @include('components.section-title', ['title' => $post->name, 'page' => false])
@endsection

@section('left-content')

        <div class="blog_area">
            <article class="blog_single blog-details">
                <header class="entry-header">
                    <span class="post-category">
{{--                        <a href="single-blog.html#"> Fashion</a>, <a href="single-blog.html#">WordPress</a>--}}
                    </span>
                    <span class="post-author">
                        <span class="post-by">Автор : </span> {{$post->author->name}}
                    </span>
                    <span class="post-separator">|</span>
                    <span class="blog-post-date"><i class="fas fa-calendar-alt"></i>{{ getRusDate($post->date_add, 'd %MONTH% Y') }} </span>
                    <span class="post-separator">|</span>
                    <span class="post-separator"><a href="#comments">Комментарии ({{ $post->comments->count() }})</a></span>
                    <span class="post-separator">|</span>
                    <span class="post-separator"><i class="fa fa-eye"></i> {{$post->view}}</span>

                </header>
                @if($post->getImage())
                <img src="{{ asset($post->getImage('900x')) }}" alt="{{ $post->name }}" class="img-fluid">
                @endif
                <div class="postinfo-wrapper">
                    <div class="post-info">
                        <div class="entry-summary blog-post-description">

                            @if($contents)
                            <div class="row mb-5 mt-5">
                                <div class="col-md-6">
                                    <h3>Содержание:</h3>
                                    <div class="list-group list-group-flush">
                                    @foreach($contents as $key => $value)
                                        <a href="#{{$key}}" class="list-group-item text-left btn btn-link" role="button">{{$value}}</a>
                                    @endforeach
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    @include('components.reklama.yandex_blog_post_list')
                                </div>
                            </div>
                            @endif

{{--                            @admin--}}
{{--                            <div id="{{$post->id}}" contenteditable="true" data-url="{{route('blog.content.editable')}}">--}}
{{--                                {!! $post->content !!}--}}
{{--                            </div>--}}
{{--                            @else--}}
                            {!! $post->content !!}
{{--                            @endadmin--}}

                            <div class="clearfix"></div>
                            <div class="single-post-tag">
                                Тэги:
{{--                                <a href="single-blog.html">fashion</a>,--}}
{{--                                <a href="single-blog.html">t-shirt</a>,--}}
{{--                                <a href="single-blog.html">white</a>,--}}
                            </div>

{{--                            <div class="social-sharing">--}}
{{--                                <div class="widget widget_socialsharing_widget">--}}
{{--                                    <h3 class="widget-title">Поделиться этим постом с друзьями</h3>--}}
{{--                                    <ul class="blog-social-icons">--}}
{{--                                        <li>--}}
{{--                                            <a target="_blank" title="Facebook" href="single-blog.html#" class="facebook social-icon">--}}
{{--                                                <i class="fa fa-facebook"></i>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a target="_blank" title="twitter" href="single-blog.html#" class="twitter social-icon">--}}
{{--                                                <i class="fa fa-twitter"></i>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a target="_blank" title="pinterest" href="single-blog.html#" class="pinterest social-icon">--}}
{{--                                                <i class="fa fa-pinterest"></i>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li>--}}
{{--                                            <a target="_blank" title="linkedin" href="single-blog.html#" class="linkedin social-icon">--}}
{{--                                                <i class="fa fa-linkedin"></i>--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </article>
            <div class="relatedposts">
                <h3>Рекомендуемые статьи</h3>
                <div class="row">
                    @foreach($relatedPosts as $relatedPost)
                    <div class="col-md-3">
                        <div class="relatedthumb">
                            <div class="image img-full">
                                <a href="{{route('blog.post', ['slug' => $relatedPost->slug])}}"><img src="{{ asset($relatedPost->getImage('660x495')) }}" alt=""></a>
                            </div>
                            <h4><a href="{{route('blog.post', ['slug' => $relatedPost->slug])}}">{{$relatedPost->name}}</a></h4>
{{--                            <span class="rl-post-date">{{getRusDate($post->date_add)}}</span>--}}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
{{--        <div class="">--}}
{{--            @include('components.reklama.google_related')--}}
{{--        </div>--}}
        <a name="comments"></a>
        <div class="comments-area mt-80" id="parent_coment">
            @if(count($comments) > 0)
                <h3>Коментарии:</h3>
                @include('components.comment-item', ['comments' => $comments])
            @else
                <h3 class="mt-5">Вы можете оставить первый комментарий!</h3>
            @endif
        </div>
        <div class="comment-box mt-30 mb-40" id="form_add_comment">
            @include('components.comment-form', ['post_id' => $post->id, 'url' => route('vinograd.ajax-comment.add')])
        </div>
@endsection

{{--@section('scripts')--}}
{{--    @admin--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>--}}

{{--    <script src="/js/ckeditor/ckeditor.js"></script>--}}
{{--    <script>--}}
{{--        CKEDITOR.disableAutoInline = true;--}}
{{--        CKEDITOR.config.toolbar = 'InlineToolbar';--}}
{{--        CKEDITOR.config.disableNativeSpellChecker = false;--}}

{{--        $("div[contenteditable='true']" ).each(function( index ) {--}}
{{--            var post_id = $(this).attr('id');--}}
{{--            var url = $(this).data('url');--}}

{{--            const Toast = Swal.mixin({--}}
{{--                toast: true,--}}
{{--                position: 'top-end',--}}
{{--                showConfirmButton: false,--}}
{{--                timer: 2500,--}}
{{--            });--}}

{{--            CKEDITOR.inline( post_id, {--}}
{{--                on: {--}}
{{--                    blur: function( event ) {--}}
{{--                        jQuery.ajax({--}}
{{--                            url: url,--}}
{{--                            type: "POST",--}}
{{--                            headers: {'X-CSRF-Token': $("input[name = '_token']").val()},--}}
{{--                            data: {--}}
{{--                                content : event.editor.getData(),--}}
{{--                                post_id : post_id--}}
{{--                            },--}}
{{--                            dataType: "json"--}}
{{--                        })--}}
{{--                        .done(function(data) {--}}
{{--                            if(data.succes) {--}}
{{--                                Toast.fire({--}}
{{--                                    icon: 'success',--}}
{{--                                    title: '<h2 class="text-success">Oтлично!</h2>',--}}
{{--                                    footer: '<p class="text-success">Данные сохранены.</p>'--}}
{{--                                })--}}
{{--                            } else if(data.errors) {--}}
{{--                                if((typeof data.errors) != 'string'){--}}
{{--                                    var temp = '';--}}
{{--                                    for (var error in data.errors){--}}
{{--                                        temp = temp + '<li>' + data.errors[error] + "</li>";--}}
{{--                                    }--}}
{{--                                }else{--}}
{{--                                    temp = '<li>' + data + "</li>";--}}
{{--                                }--}}

{{--                                // Swal.fire({--}}
{{--                                //     icon: 'error',--}}
{{--                                //     title: 'Oops...',--}}
{{--                                //     text: '<div class="text-danger">'+temp+'</div>',--}}
{{--                                //     footer: '<a href>Why do I have this issue?</a>'--}}
{{--                                // })--}}

{{--                                Toast.fire({--}}
{{--                                    icon: 'error',--}}
{{--                                    title: '<h2 class="text-danger">Ошибка ...</h2>',--}}
{{--                                    footer: '<div class="text-danger">'+temp+'</div>'--}}
{{--                                    // footer: '<p class="text-danger">Повторите попытку.</p>'--}}

{{--                                });--}}
{{--                                console.log(data.errors);--}}
{{--                            } else {--}}
{{--                                alert('errors 2 '+data);--}}
{{--                                console.log(data);--}}
{{--                                //errors_list('Неизвестная ошибка. Повторите попытку, пожалуйста!');--}}
{{--                            }--}}
{{--                        })--}}
{{--                        .fail(function(xhr, ajaxOptions, thrownError) {--}}
{{--                            alert('errors 3 ');--}}

{{--                            console.log(xhr.responseText);--}}
{{--                            //fail_list(xhr.responseText);--}}
{{--                            //console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);--}}
{{--                        });--}}
{{--                    }--}}
{{--                },--}}
{{--                // toolbar: [--}}
{{--                //     ['Bold','Italic','Underline'],--}}
{{--                //     ['NumberedList','BulletedList'],--}}
{{--                //     ['JustifyLeft','JustifyCenter','JustifyRight'],--}}
{{--                //     ['Undo','Redo'],--}}
{{--                //     '/',--}}
{{--                //     ['TextColor','Font','FontSize']--}}
{{--                // ],--}}
{{--                // toolbarGroups: [--}}
{{--                //     { name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.--}}
{{--                //     { name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },			// Group's name will be used to create voice label.--}}
{{--                //     '/',																// Line break - next group will be placed in new line.--}}
{{--                //     { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },--}}
{{--                //     { name: 'links' }--}}
{{--                // ]--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--    @endadmin--}}
{{--@endsection--}}
