<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationTemplate;
use Illuminate\Http\Request;

class NotificationTemplateController extends Controller
{
    public function index()
    {
        $templates = NotificationTemplate::latest()->get();
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        NotificationTemplate::create($request->all());
        return redirect()->route('admin.templates.index');
    }

    public function edit($id)
    {
        $template = NotificationTemplate::findOrFail($id);
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = NotificationTemplate::findOrFail($id);
        $template->update($request->all());
        return redirect()->route('admin.templates.index');
    }

    public function destroy($id)
    {
        NotificationTemplate::destroy($id);
        return back();
    }
}