<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\LegalPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LegalController extends Controller
{
    public function manageLegal()
    {
        $legalPages = LegalPage::orderBy('position_order')->get();
        foreach ($legalPages as $page) {
            $page->encrypted_id = Crypt::encrypt($page->id);
        }

        $currentPage = 'manage_legal';

        return view('admin.manage_legal', compact('legalPages', 'currentPage'));
    }

    public function editLegal(Request $request, $legal)
    {
        $id = Crypt::decrypt($legal);
        $legalPage = LegalPage::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string',
                'meta_title' => 'required|string',
                'meta_keyword' => 'required|string',
                'meta_description' => 'required|string',
                'description' => 'required',
            ], [
                'title.required' => 'Title is required!',
                'meta_title.required' => 'Meta title is required!',
                'meta_keyword.required' => 'Meta keywords are required!',
                'meta_description.required' => 'Meta description is required!',
                'description.required' => 'Description is required!',
            ]);

            $legalPage->title = $request->title;
            $legalPage->description = htmlspecialchars($request->description, ENT_QUOTES);
            $legalPage->meta_title = $request->meta_title;
            $legalPage->meta_keyword = $request->meta_keyword;
            $legalPage->meta_description = htmlspecialchars($request->meta_description, ENT_QUOTES);
            $legalPage->status = $request->status ?? 'active';

            if ($legalPage->save()) {
                $request->session()->flash('success', 'Legal page updated successfully!');
                return redirect()->route('admin.manage_legal');
            }

            $request->session()->flash('error', 'Update failed!');
            return redirect()->route('admin.edit.legal', $legal);
        }

        $legalPage->encrypted_id = Crypt::encrypt($legalPage->id);
        $currentPage = 'manage_legal';

        return view('admin.legal-ops', compact('legalPage', 'currentPage'));
    }
}
