<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Models\Vinograd\ModificationProps;
use Illuminate\Http\Request;
use View;

class ModificationsController extends AppController
{
    public function __construct()
    {
        parent::__construct();
        View::share ('modification_active', ' active');
    }

    public function index()
    {
        return view('admin.vinograd.modification.index', [
            'modifications' => ModificationProps::all()
        ]);
    }

    public function create()
    {
        return view('admin.vinograd.modification.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' =>  'required|max:100'
        ]);

        return redirect()->route('modifications.index');
    }

    public function edit($id)
    {
        return view('admin.vinograd.modification.edit', [
            'modification' => ModificationProps::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('modifications.index');
    }

    public function destroy($id)
    {
        //  Проверить на использование

        ModificationProps::findOrFail($id)->delete();

        return redirect()->route('modifications.index');
    }

    public function toggle($id)
    {
        $page = ModificationProps::findOrFail($id);
        $page->toggledsStatus();

        return redirect()->back();
    }
}