<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $user = Auth::user();
        
        $query = $user->notes();
        
        if ($filter === 'important') {
            $query->where('is_important', true);
        } elseif ($filter === 'bookmarked') {
            $query->where('is_bookmarked', true);
        }
        
        $notes = $query->latest()->get();
        
        return view('notes.index', compact('notes', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'color' => 'required|in:yellow,light-blue,beige',
        ]);

        $note = Auth::user()->notes()->create([
            'title' => $request->title,
            'content' => $request->content,
            'color' => $request->color,
            'is_important' => $request->has('is_important'),
            'is_bookmarked' => $request->has('is_bookmarked'),
        ]);

        // Handle file attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                
                $note->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('notes.index')
            ->with('success', 'Note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        $this->authorize('view', $note);
        
        return view('notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        $this->authorize('update', $note);
        
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'color' => 'required|in:yellow,light-blue,beige',
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content,
            'color' => $request->color,
            'is_important' => $request->has('is_important'),
            'is_bookmarked' => $request->has('is_bookmarked'),
        ]);

        // Handle file attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('attachments', 'public');
                
                $note->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_type' => $file->getClientMimeType(),
                    'file_size' => $file->getSize(),
                ]);
            }
        }

        return redirect()->route('notes.show', $note)
            ->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        
        // Delete attachments
        foreach ($note->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }
        
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Note deleted successfully.');
    }

    /**
     * Toggle important status.
     */
    public function toggleImportant(Note $note)
    {
        $this->authorize('update', $note);
        
        $note->update([
            'is_important' => !$note->is_important,
        ]);

        return back()->with('success', 'Note updated successfully.');
    }

    /**
     * Toggle bookmarked status.
     */
    public function toggleBookmarked(Note $note)
    {
        $this->authorize('update', $note);
        
        $note->update([
            'is_bookmarked' => !$note->is_bookmarked,
        ]);

        return back()->with('success', 'Note updated successfully.');
    }
}