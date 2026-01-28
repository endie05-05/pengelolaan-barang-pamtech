<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ProjectTemplate;
use App\Models\TemplateItem;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the templates.
     */
    public function index()
    {
        $templates = ProjectTemplate::withCount('items')->latest()->paginate(15);

        return view('templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new template.
     */
    public function create()
    {
        $items = Item::orderBy('name')->get();

        return view('templates.create', compact('items'));
    }

    /**
     * Store a newly created template.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.default_qty' => 'required|integer|min:1',
        ]);

        $template = ProjectTemplate::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        foreach ($validated['items'] as $itemData) {
            TemplateItem::create([
                'project_template_id' => $template->id,
                'item_id' => $itemData['item_id'],
                'default_qty' => $itemData['default_qty'],
            ]);
        }

        return redirect()->route('templates.index')
            ->with('success', 'Template berhasil dibuat!');
    }

    /**
     * Display the specified template.
     */
    public function show(ProjectTemplate $template)
    {
        $template->load('items.item.category');

        return view('templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified template.
     */
    public function edit(ProjectTemplate $template)
    {
        $template->load('items');
        $items = Item::orderBy('name')->get();

        return view('templates.edit', compact('template', 'items'));
    }

    /**
     * Update the specified template.
     */
    public function update(Request $request, ProjectTemplate $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.item_id' => 'required|exists:items,id',
            'items.*.default_qty' => 'required|integer|min:1',
        ]);

        $template->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
        ]);

        // Sync items
        $template->items()->delete();
        foreach ($validated['items'] as $itemData) {
            TemplateItem::create([
                'project_template_id' => $template->id,
                'item_id' => $itemData['item_id'],
                'default_qty' => $itemData['default_qty'],
            ]);
        }

        return redirect()->route('templates.show', $template)
            ->with('success', 'Template berhasil diperbarui!');
    }

    /**
     * Remove the specified template.
     */
    public function destroy(ProjectTemplate $template)
    {
        $template->delete();

        return redirect()->route('templates.index')
            ->with('success', 'Template berhasil dihapus!');
    }
}
