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
        $query = Contact::latest();

        if ($request->filled('form_type')) {
            $query->where('form_type', $request->form_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('form_type_label', fn ($row) => $row->form_type_label)
            ->addColumn('submitted_at', fn ($row) => $row->created_at?->format('d M Y, h:i A') ?? '—')
            ->addColumn('status_badge', function ($row) {
                $class = match ($row->status ?? 'new') {
                    'read' => 'bg-secondary',
                    'replied' => 'bg-success',
                    default => 'bg-primary',
                };

                return '<span class="badge '.$class.'">'.ucfirst($row->status ?? 'new').'</span>';
            })
            ->addColumn('action', function ($row) {
                $detailUrl = route('admin.contactform_detail', encrypt($row->id));

                return '<a href="'.$detailUrl.'" class="btn btn-sm btn-primary">View</a>';
            })
            ->rawColumns(['action', 'status_badge'])
            ->make(true);
    }

    public function contactform_detail($id)
    {
        $contact = Contact::findOrFail(decrypt($id));

        if (($contact->status ?? 'new') === 'new') {
            $contact->update(['status' => 'read']);
        }

        return view('admin.contact_form_detail', compact('contact'));
    }

    public function contactform_delete(Request $request)
    {
        $request->validate(['id' => 'required']);

        $contact = Contact::findOrFail(decrypt($request->id));
        $contact->delete();

        return response()->json(['success' => 'Lead deleted successfully.']);
    }

    public function contactform_status(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required|in:new,read,replied',
        ]);

        $contact = Contact::findOrFail(decrypt($request->id));
        $contact->update(['status' => $request->status]);

        return response()->json(['success' => 'Status updated.']);
    }
}
