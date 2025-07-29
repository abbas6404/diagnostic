<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CollectionKit;
use Illuminate\Support\Facades\Auth;

class CollectionKitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $collectionKits = CollectionKit::withTrashed()
            ->with(['createdBy', 'updatedBy'])
            ->orderBy('name')
            ->get();

        return view('admin.setup.collection-kit.index', compact('collectionKits'));
    }

    public function create()
    {
        return view('admin.setup.collection-kit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pcode' => 'required|string|max:50|unique:collection_kits,pcode',
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
            'charge' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,group_test',
        ]);

        try {
            CollectionKit::create([
                'pcode' => $request->pcode,
                'name' => $request->name,
                'color' => $request->color,
                'charge' => $request->charge,
                'status' => $request->status,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('admin.setup.collection-kit.index')
                ->with('success', 'Collection kit created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create collection kit: ' . $e->getMessage());
        }
    }

    public function show(CollectionKit $collectionKit)
    {
        $collectionKit->load(['createdBy', 'updatedBy', 'labTests.department']);
        return view('admin.setup.collection-kit.show', compact('collectionKit'));
    }

    public function edit(CollectionKit $collectionKit)
    {
        return view('admin.setup.collection-kit.edit', compact('collectionKit'));
    }

    public function update(Request $request, CollectionKit $collectionKit)
    {
        $request->validate([
            'pcode' => 'required|string|max:50|unique:collection_kits,pcode,' . $collectionKit->id,
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:50',
            'charge' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,group_test',
        ]);

        try {
            $collectionKit->update([
                'pcode' => $request->pcode,
                'name' => $request->name,
                'color' => $request->color,
                'charge' => $request->charge,
                'status' => $request->status,
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('admin.setup.collection-kit.index')
                ->with('success', 'Collection kit updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update collection kit: ' . $e->getMessage());
        }
    }

    public function destroy(CollectionKit $collectionKit)
    {
        try {
            $collectionKit->delete();
            return redirect()->route('admin.setup.collection-kit.index')
                ->with('success', 'Collection kit deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete collection kit: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $collectionKit = CollectionKit::withTrashed()->findOrFail($id);
            $collectionKit->restore();
            
            return redirect()->route('admin.setup.collection-kit.index')
                ->with('success', 'Collection kit restored successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore collection kit: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $collectionKit = CollectionKit::withTrashed()->findOrFail($id);
            $collectionKit->forceDelete();
            
            return redirect()->route('admin.setup.collection-kit.index')
                ->with('success', 'Collection kit permanently deleted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete collection kit: ' . $e->getMessage());
        }
    }
} 