<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceUploadController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Save the file to the 'invoices' directory in storage (e.g., storage/app/invoices)
            $path = $file->store('invoices');


            // Save the file information to the database
            Upload::create([
                'company_id' => 1,
                'invoice_id' => $request->invoice_id, // Optional
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize() / 1024, // Size in KB
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'file_path' => $path
            ]);
        }

        return response()->json(['error' => 'File not uploaded'], 400);
    }
}
