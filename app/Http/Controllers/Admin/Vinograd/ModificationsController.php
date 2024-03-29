<?php

namespace App\Http\Controllers\Admin\Vinograd;

use App\Models\Vinograd\ModificationProps;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'name' =>  'required|max:100|unique:vinograd_modifications',
            'weight' =>  'required|integer'
        ]);
        ModificationProps::create($request->all());
        return redirect()->route('modifications.index');
    }

    public function edit($id)
    {
        return view('admin.vinograd.modification.edit', [
            'modification' => ModificationProps::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' =>  [
                'required',
                'max:100',
                Rule::unique('vinograd_modifications')->ignore($id),
            ],
            'weight' =>  'required|integer'
        ]);
        $modification = ModificationProps::find($id);
        $modification->edit($request->all());
        return redirect()->route('modifications.index');
    }

    public function destroy($id)
    {
        //  Проверить на использование

        ModificationProps::find($id)->delete();

        return redirect()->route('modifications.index');
    }

    public function toggle($id)
    {
        $page = ModificationProps::find($id);
        $page->toggledsStatus();

        return redirect()->back();
    }
}
