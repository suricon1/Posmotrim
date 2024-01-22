<?php

namespace App\Http\Controllers\Admin;

use App\UseCases\ImageService;
use App\UseCases\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Storage;
use Validator;

class AppAjaxController extends Controller
{

    /*-------------------------------------------------------------
     * Метод принимает и сохраняет фото Ajax запросом из CKEDITOR
     *------------------------------------------------------------*/
    public function upload(Request $request)
    {
        $v = Validator::make($request->all(), [
            'upload' => 'required|image|mimes:jpg,jpeg,png|dimensions:max_width=900,max_height=900|max:500'
        ],
        [
            'dimensions' => 'Максимальный размер изображения должен быть 900px на 900px',
            'max' => 'Максимальный вес изображения должен быть 500кб',
            'mimes' => 'Изображение должно иметь формат: jpg,jpeg,png'
        ]);

        $funcNum = $request->input('CKEditorFuncNum');

        if ($v->fails()) {
            return response(
                "<script>
                    window.parent.CKEDITOR.tools.callFunction({$funcNum}, '', '{$v->errors()->first()}');
                </script>"
            );
        }

        $file = $request->file('upload');
        $filename = STR::random(20) . '.' . $file->extension();

        $img = new ImageService(new Size('0x0'));

        $img->saveImage($file, storage_path('app/public/pics/uploads/').$filename);

        $url = Storage::url('pics/uploads/'.$filename);

        return response(
            "<script>
                window.parent.CKEDITOR.tools.callFunction({$funcNum}, '{$url}'/*, 'Изображение успешно загружено'*/);
            </script>"
        );
    }
}
