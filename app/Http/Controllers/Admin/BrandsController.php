<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    public function manageBrands()
    {
        $currentPageName = 'Brands';
        $currentPageData = 'brand';
        $addNewData = 'admin.add.brand';
        $deleteUrl = 'admin.brand.delete';

        return view('admin.manage_brands', compact('currentPageName', 'currentPageData', 'addNewData', 'deleteUrl'));
    }

    public function brand_data(Request $request)
    {
        $data = Brand::latest()->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('brand_image', function ($row) {
                if ($row->brand_image) {
                    return '<img src="' . asset($row->brand_image) . '" width="60" height="50" class="rounded">';
                }

                return '';
            })
            ->addColumn('is_active', function ($row) {
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.edit.brand', encrypt($row->id));
                $deleteId = encrypt($row->id);
                $model = 'Brand';

                return '<div class="dropdown">
                        <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                            <i class="feather-more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                            <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="' . $model . '">Delete</button>
                        </div>
                    </div>';
            })
            ->rawColumns(['brand_image', 'action'])
            ->make(true);
    }

    public function brand_delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'model' => 'required',
        ]);

        try {
            $id = decrypt($request->id);
            $modelName = '\\App\\Models\\' . $request->model;

            if (!class_exists($modelName)) {
                throw new \Exception('Model not found.');
            }

            $modelName::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Brand deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid ID or brand not found.',
            ], 400);
        }
    }

    public function addBrand(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|unique:brands,name',
                'brand_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120',
                'is_active' => 'required|in:0,1',
            ]);

            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = Str::slug($request->name);
            $brand->is_active = $request->is_active == 1;
            $brand->is_featured = 1;

            if (!empty($request->file('brand_image'))) {
                $path = 'images/brands/';
                $brand->brand_image = $this->storeImage($request->file('brand_image'), $path);
            }

            $brand->save();

            return redirect()->route('admin.manage_brands')->with('success', 'Brand added successfully.');
        }

        $currentPageName = 'Brand';
        $addNewData = 'admin.add.brand';
        $allData = 'admin.manage_brands';

        return view('admin.brand-ops', compact('currentPageName', 'addNewData', 'allData'));
    }

    public function editBrand(Request $request, $brand)
    {
        $id = decrypt($brand);
        $memberCategory = Brand::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|unique:brands,name,' . $memberCategory->id,
                'brand_image' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120',
                'is_active' => 'required|in:0,1',
            ]);

            $memberCategory->name = $request->name;
            $memberCategory->slug = Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1;
            $memberCategory->is_featured = 1;

            if (!empty($request->file('brand_image'))) {
                $path = 'images/brands/';
                $memberCategory->brand_image = $this->storeImage(
                    $request->file('brand_image'),
                    $path,
                    $memberCategory->brand_image
                );
            }

            $memberCategory->save();

            return redirect()->route('admin.manage_brands')->with('success', 'Brand updated successfully.');
        }

        $currentPageName = 'Brand';
        $editData = 'admin.edit.brand';
        $memberCategory->encrypted_id = $brand;
        $allData = 'admin.manage_brands';

        return view('admin.brand-ops', compact('currentPageName', 'editData', 'memberCategory', 'allData'));
    }

    public function getBrands()
    {
        return Brand::where('is_active', true)->where('is_featured', true)->get();
    }
}
