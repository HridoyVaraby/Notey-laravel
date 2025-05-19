<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Download the specified attachment.
     */
    public function download(Attachment $attachment)
    {
        $this->authorize('view', $attachment->note);
        
        return Storage::disk('public')->download(
            $attachment->file_path,
            $attachment->file_name
        );
    }

    /**
     * Remove the specified attachment from storage.
     */
    public function destroy(Attachment $attachment)
    {
        $this->authorize('update', $attachment->note);
        
        // Delete the file
        Storage::disk('public')->delete($attachment->file_path);
        
        // Delete the record
        $attachment->delete();

        return back()->with('success', 'Attachment deleted successfully.');
    }
}