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
       $validated = $request->validate([
    'title' => 'required|string|max:255',
    'subject' => 'required|string|max:255',
    'message' => 'required|string',
    'type' => 'required|in:email,sms',
]);

        NotificationTemplate::create($validated);

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template created successfully');
    }

    public function edit($id)
    {
        $template = NotificationTemplate::findOrFail($id);
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:email,sms',
        ]);

        $template = NotificationTemplate::findOrFail($id);
        $template->update($validated);

        return redirect()
            ->route('admin.templates.index')
            ->with('success', 'Template updated successfully');
    }

    public function destroy($id)
    {
        NotificationTemplate::findOrFail($id)->delete();

        return back()->with('success', 'Template deleted successfully');
    }
}