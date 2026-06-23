<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function manage_contact_form()
    {
        return view('admin.manage_contact_form');
    }

    public function contactform_data(Request $request)
    {
        $data = Contact::latest()->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $detailUrl = route('admin.contactform_detail', encrypt($row->id));

                return '<a href="'.$detailUrl.'" class="btn btn-sm btn-primary">View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function contactform_detail($id)
    {
        $contact = Contact::findOrFail(decrypt($id));

        return view('admin.contact_form_detail', compact('contact'));
    }
}
