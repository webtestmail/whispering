<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BrandsController extends Controller
{
    public function manageBrands()
    {
        $brands = Brands::select('id', 'position_order', 'brand_name', 'brand_image', 'status')->get();
        foreach ($brands as $brand) {
            $brand->encrypted_id = Crypt::encrypt($brand->id);
        }
        $model = Crypt::encrypt('Brands');
        $currentPage = "manage_brands";
        return view('admin.manage_brands', ['brandsData' => $brands, 'model' => $model, "currentPage" => $currentPage]);
    }

    public function addBrand(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'brand_name' => 'required|string',
                'brand_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120',
            ]);

            $brand_order = Brands::max('position_order');
            $position_order = ($brand_order !== null) ? $brand_order + 1 : 1;

            $brand = [
                'position_order' => $position_order,
                'brand_name' => $request->brand_name,
            ];

            if (!empty($request->file('brand_image'))) {
                $path = 'images/brands/';
                $filePath = $this->storeImage($request->file('brand_image'), $path);
                $brand['brand_image'] = $filePath;
            }

            if (Brands::create($brand)) {
                $request->session()->flash('success', 'Brand is added Successfully!');
                return redirect()->route('admin.manage_brands');
            } else {
                $request->session()->flash('error', 'Insertion Error!');
                return redirect()->route('admin.add.brand');
            }
        } else {
            $currentPage = "manage_brands";
            return view('admin.brand-ops', ["currentPage" => $currentPage]);
        }
    }

    public function editBrand(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'brand_name' => 'required|string',
                'brand_image' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120',
            ]);

            $id = Crypt::decrypt($request->brand);
            $brand = Brands::findOrFail($id);
            $brand->brand_name = $request->brand_name;

            if (!empty($request->file('brand_image'))) {
                $path = 'images/brands/';
                $filePath = $this->storeImage($request->file("brand_image"), $path, $brand->brand_image);
                $brand->brand_image = $filePath;
            }

            if ($brand->save()) {
                $request->session()->flash('success', 'Brand is updated Successfully!');
                return redirect()->route('admin.manage_brands');
            } else {
                $request->session()->flash('error', 'Updation Error!');
                return redirect()->route('admin.edit.brand', $request->brand);
            }
        } else {
            $id = Crypt::decrypt($request->brand);
            $brand = Brands::where('id', $id)->firstOrFail();
            $brand->encrypted_id = $request->brand;
            $currentPage = "manage_brands";
            return view('admin.brand-ops', ["brand" => $brand, "currentPage" => $currentPage]);
        }
    }

    public function getBrands()
    {
        return Brands::where('status', 'active')->get();
    }
}
