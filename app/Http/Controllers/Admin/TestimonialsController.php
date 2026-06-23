<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Testimonials;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;

class TestimonialsController extends Controller
{
    public function manageTestimonials()
    {
        $testimonials = Testimonials::select('id', 'position_order', 'client_name', 'client_image', 'rating_quantity', 'status')->get();
        foreach ($testimonials as $testimonial) {
            $testimonial->encrypted_id = Crypt::encrypt($testimonial->id);
        }
        $currentPage = "manage_testimonials";
        $model = Crypt::encrypt('Testimonials');
        return view('admin.manage_testimonials', ['testimonialsData' => $testimonials, 'model' => $model, 'currentPage' => $currentPage]);
    }


     public function testimonial_data() {

          $data = Testimonials::select('id', 'client_name', 'status')->orderBy('position_order')->get();

                return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('client_name', function($data){
                return strip_tags($data->client_name);
            })
            ->addColumn('is_active', function($data){
                return $data->status == 'active' ? 'Active' : 'In active';
            })
            ->addColumn('action', function ($data) {
                $encryptedId = Crypt::encrypt($data->id);
                $model = Crypt::encrypt('Testimonials');
                return '<div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="' . route('admin.edit.testimonial', encrypt($data->id)) . '" class="dropdown-item">Modify</a>
                                     <button class="dropdown-item delete"
                                    onclick="delete_item(\'' . $model . '\', \'' . $encryptedId . '\');"
                                    data-id="' . $data->id . '">
                                Delete
                            </button>
                            </div>
                        </div>';
            })
            // ->rawColumns(['action','question','is_active','category_name'])
            ->make(true);
    }

    public function addTestimonial(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'client_name' => 'required|string',
                'rating' => 'required|string',
                'description' => 'required',
                'company_name' => 'required',
                'designation' => 'required'
            ], [
                'client_name.required' => 'The client name is required.',
                'client_name.string' => 'The client name must be a string.',
                'rating.required' => 'The rating quantity is required.',
            ]);

            $page_order = Testimonials::max('position_order');
            $position_order = ($page_order !== null) ? $page_order + 1 : 1;

            $testimonial = [
                'position_order' => $position_order,
                'client_name' => $request->client_name,
                'client_designation' => $request->designation,
                'rating_quantity' => $request->rating,
                'company_name' => $request->company_name,
                'description' => htmlspecialchars($request->description, ENT_QUOTES),
                'status' => $request->status,
            ];

            if (!empty($request->file('client_image'))) {
                $path = 'images/testimonials/';
                $filePath = $this->storeImage($request->file('client_image'), $path);
                $testimonial['client_image'] = $filePath;
            }

            if (Testimonials::create($testimonial)) {
                session()->flash('success', 'Testimonial is inserted Successfully!');
                return redirect()->route('admin.manage_testimonials');
            } else {
                session()->flash('error', 'Insertion Error!');
                return redirect()->route('admin.add.testimonial');
            }
        } else {
            $currentPage = "manage_testimonials";
            return view('admin.testimonial-ops', ['currentPage' => $currentPage]);
        }
    }

    public function editTestimonial(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
            'client_name' => 'required|string',
                'rating' => 'required|string',
                'description' => 'required',
                'company_name' => 'required',
                'designation' => 'required'
            ], [
                'client_name.required' => 'The client name is required.',
                'client_name.string' => 'The client name must be a string.',
                'rating_quantity.required' => 'The rating quantity is required.',
                'rating_quantity.string' => 'The rating quantity must be a string.',
            ]);

            $id = Crypt::decrypt($request->testimonial);
            $testimonial = Testimonials::findOrFail($id);
            $testimonial->client_name = $request->client_name;
            $testimonial->client_designation = $request->designation;
            $testimonial->company_name = $request->company_name;
            $testimonial->rating_quantity = $request->rating;
            $testimonial->rating_quantity = $request->rating;
            $testimonial->position_order = $request->position_order;
            $testimonial->status = $request->status;
            $testimonial->description = htmlspecialchars($request->description, ENT_QUOTES);

            if (!empty($request->file('client_image'))) {
                $path = 'images/testimonials/';
                $filePath = $this->storeImage($request->file("client_image"), $path, $testimonial->client_image);
                $testimonial->client_image = $filePath;
            }

            if ($testimonial->save()) {
                session()->flash('success', 'Testimonial is updated Successfully!');
                return redirect()->route('admin.manage_testimonials');
            } else {
                session()->flash('error', 'Updation Error!');
                return redirect()->route('admin.edit.testimonial', $request->testimonial);
            }
        } else {
            $id = Crypt::decrypt($request->testimonial);
            $testimonial = Testimonials::where('id', $id)->firstOrFail();
            $testimonial->encrypted_id = $request->testimonial;
            $currentPage = "manage_testimonials";
            return view('admin.testimonial-ops', ["testimonial" => $testimonial, 'currentPage' => $currentPage]);
        }
    }

    public function getAllTestimonials()
    {
        return Testimonials::where('status', 'active')->orderBy('position_order')->get();
    }
}
