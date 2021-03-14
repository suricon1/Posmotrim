<?php

namespace App\Http\Controllers\Admin;

use App\UseCases\ImageService;
use App\UseCases\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            'upload' => 'required|image|mimes:jpg,jpeg,png|dimensions:max_width=900,max_height=600|max:500'
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
        $filename = str_random(20) . '.' . $file->extension();

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
