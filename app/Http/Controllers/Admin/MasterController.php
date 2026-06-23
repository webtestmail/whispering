<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class MasterController extends Controller
{
    public function manageMemberCategories()
    {
        $currentPageName = 'Member Categories';
        $currentPageData = 'member_categories';
        $addNewData = 'admin.add.member_category';
        $deleteUrl = 'admin.member_category.delete';
        return view('admin.manage_member_categories', compact('currentPageName', 'currentPageData', 'addNewData', 'deleteUrl'));
    }
    public function member_category_data(Request $request)
    {
        $data = \App\Models\MemberCategory::latest()->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.member_category.edit', encrypt($row->id));
                $deleteId = encrypt($row->id);
                $model = 'MemberCategory';
                return '<div class="dropdown">
                        <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                            <i class="feather-more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                            <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="'.$model.'">Delete</button>

                        </div>

                    </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function addMemberCategory(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:member_categories,name',
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory = new \App\Models\MemberCategory();
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->save();
            return redirect()->route('admin.manage_member_categories')->with('success', 'Member Category added successfully.');
        }
        else{
            
            $currentPageName = 'Member Category';
            $addNewData = 'admin.add.member_category';
            return view('admin.member-category-ops', compact('currentPageName', 'addNewData'));
        }
        $currentPageName = 'Member Category';
        return view('admin.member-category-ops', compact('currentPageName', 'addNewData'));
    }

    public function member_category_edit(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $memberCategory = \App\Models\MemberCategory::findOrFail($id);
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:member_categories,name,'.$memberCategory->id,
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->save();
            return redirect()->route('admin.manage_member_categories')->with('success', 'Member Category updated successfully.');
        }
        else{
            
            $currentPageName = 'Member Category';
            $editData = 'admin.member_category.edit';
            $memberCategory->encrypted_id = $encrypted_id;
            return view('admin.member-category-ops', compact('currentPageName', 'editData', 'memberCategory'));
        }
    }
    public function deleteData(Request $request) {
        try {
            $id = decrypt($request->id);
            
            $modelName = "\\App\\Models\\" . $request->model;
            
            // Check if the class actually exists to avoid a fatal error
            if (!class_exists($modelName)) {
                throw new \Exception("Model not found.");
            }

            $data = $modelName::findOrFail($id);
            $data->delete();    

            return response()->json([
                'success' => true,
                'message' => 'Data deleted Successfully',
            ]);
        }
        catch(\Exception $e) {
            return response()->json([
                'success' => false, // Removed quotes to keep it a boolean
                'message' => 'Invalid ID or Data not Found',
                'debug' => $e->getMessage() // Optional: remove this in production
            ], 400); // Added 400 status code so AJAX "error" block triggers
        }
    }

  public function manageCountry()
    {
        $currentPageName = 'Country';
        $currentPageData = 'countries';
        $addNewData = 'admin.add.country';
        $deleteUrl = 'admin.country.delete';
        return view('admin.manage_countries', compact('currentPageName', 'currentPageData', 'addNewData', 'deleteUrl'));
    }
    public function country_data(Request $request)
    {
        $data = \App\Models\Country::latest()->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('flag', function ($row) {
                if ($row->flag) {
                    $url = asset($row->flag);
                    return '<img src="'. $url .'" width="30" height="20" class="rounded" alt="Country Flag">';
                }
                return '';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.country.edit', encrypt($row->id));
                $deleteId = encrypt($row->id);
                $model = 'Country';
                return '<div class="dropdown">
                        <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                            <i class="feather-more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                            <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="'.$model.'">Delete</button>

                        </div>

                    </div>';
            })
            ->addColumn('is_active',function($row){
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->rawColumns(['flag', 'action'])
            ->make(true);
    }
    public function add_country(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:countries,name',
                'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:2048',
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory = new \App\Models\Country();
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            if (!empty($request->file('flag'))) {
                $path = 'images/countries/';
                $filePath = $this->storeImage($request->file('flag'), $path);
                $memberCategory->flag = $filePath;
            }
            $memberCategory->save();
            return redirect()->route('admin.manage_countries')->with('success', 'Country added successfully.');
        }
        else{
            
            $currentPageName = 'Country';
            $addNewData = 'admin.add.country';
            $allData = 'admin.manage_countries';
            return view('admin.country-ops', compact('currentPageName', 'addNewData','allData'));
        }
        $currentPageName = 'Country';
        return view('admin.country-ops', compact('currentPageName', 'addNewData'));
    }
            public function country_edit(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $memberCategory = \App\Models\Country::findOrFail($id);
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:countries,name,'.$memberCategory->id,
                'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:2048',
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            if (!empty($request->file('flag'))) {
                $path = 'images/countries/';
                $filePath = $this->storeImage($request->file('flag'), $path, $memberCategory->flag);
                $memberCategory->flag = $filePath;
            }
            $memberCategory->save();
            return redirect()->route('admin.manage_countries')->with('success', 'Country updated successfully.');
        }
        else{
            
            $currentPageName = 'Country';
            $editData = 'admin.country.edit';
            $memberCategory->encrypted_id = $encrypted_id;
            $allData = 'admin.manage_countries';
            return view('admin.country-ops', compact('currentPageName', 'editData', 'memberCategory','allData'));
        }
    }
        public function manageTradeSectors()
    {
        $currentPageName = 'Trade Sector';
        $currentPageData = 'trade_sectors';
        $addNewData = 'admin.add.trade_sector';
        $deleteUrl = 'admin.trade_sector.delete';
        return view('admin.manage_trade_sectors', compact('currentPageName', 'currentPageData', 'addNewData', 'deleteUrl'));
    }
     public function trade_sector_data(Request $request)
    {
        $data = \App\Models\TradeSector::latest()->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.trade_sectors.edit', encrypt($row->id));
                $deleteId = encrypt($row->id);
                $model = 'Country';
                return '<div class="dropdown">
                        <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                            <i class="feather-more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                            <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="'.$model.'">Delete</button>

                        </div>

                    </div>';
            })
            ->addColumn('is_active',function($row){
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function add_trade_sector(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:member_categories,name',
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory = new \App\Models\TradeSector();
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->save();
            return redirect()->route('admin.manage_trade_sectors')->with('success', 'Member Category added successfully.');
        }
        else{
            
            $currentPageName = 'Trade Sector';
            $addNewData = 'admin.add.trade_sector';
            $allData = 'admin.manage_trade_sectors';
            return view('admin.trade-sectors-ops', compact('currentPageName', 'addNewData','allData'));
        }
        $currentPageName = 'Trade Sector';
        return view('admin.trade-sectors-ops', compact('currentPageName', 'addNewData'));
    }
    public function trade_sector_edit(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $memberCategory = \App\Models\TradeSector::findOrFail($id);
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:member_categories,name,'.$memberCategory->id,
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->save();
            return redirect()->route('admin.manage_trade_sectors')->with('success', 'Member Category updated successfully.');
        }
        else{
            
            $currentPageName = 'Trade Sector';
            $editData = 'admin.trade_sectors.edit';
            $memberCategory->encrypted_id = $encrypted_id;
            $allData = 'admin.manage_trade_sectors';
            return view('admin.trade-sectors-ops', compact('currentPageName', 'editData', 'memberCategory','allData'));
        }
    }
    public function manageProductCategories()
    {
        $currentPageName = 'Product Categories';
        $currentPageData = 'product_categories';
        $addNewData = 'admin.add.product_category';
        $deleteUrl = 'admin.product_category.delete';
        return view('admin.manage_product_categories', compact('currentPageName', 'currentPageData', 'addNewData', 'deleteUrl'));
    }
    public function manageTemperature()
    {
        $currentPageName = 'Temperature';
        $currentPageData = 'temperatures';
        $addNewData = 'admin.add.temperature';
        $deleteUrl = 'admin.temperature.delete';
        return view('admin.manage_temperatures', compact('currentPageName', 'currentPageData', 'addNewData', 'deleteUrl'));
    }
    public function manageBrands()
    {
        $currentPageName = 'Brands';
        $currentPageData = 'brands';
        $addNewData = 'admin.add.brand';
        $deleteUrl = 'admin.brand.delete';
        return view('admin.manage_brands', compact('currentPageName', 'currentPageData', 'addNewData', 'deleteUrl'));
    }
    public function product_category_data(Request $request)
    {
        $data = \App\Models\ProductCategory::latest()->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.product_category.edit', encrypt($row->id));
                $deleteId = encrypt($row->id);
                $model = 'ProductCategory';
                return '<div class="dropdown">
                        <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                            <i class="feather-more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                            <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="'.$model.'">Delete</button>

                        </div>

                    </div>';
            })
            ->addColumn('is_active',function($row){
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
        public function temperature_data(Request $request)
    {
        $data = \App\Models\Temperature::latest()->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.temperature.edit', encrypt($row->id));
                $deleteId = encrypt($row->id);
                $model = 'Temperature';
                return '<div class="dropdown">
                        <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                            <i class="feather-more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                            <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="'.$model.'">Delete</button>

                        </div>

                    </div>';
            })
            ->addColumn('is_active',function($row){
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
        public function brands_data(Request $request)
    {
        $data = \App\Models\Brand::latest()->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('brand_image', function ($row) {
                if ($row->brand_image) {
                    $url = asset($row->brand_image); 
                    return '<img src="'. $url .'" width="60" height="50" class="rounded">';
                }
                return '';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.brand.edit', encrypt($row->id));
                $deleteId = encrypt($row->id);
                $model = 'Brand';
                return '<div class="dropdown">
                        <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                            <i class="feather-more-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="' . $editUrl . '" class="dropdown-item">Edit</a>
                            <button class="dropdown-item delete" data-id="' . $deleteId . '" data-model="'.$model.'">Delete</button>

                        </div>

                    </div>';
            })
            ->addColumn('is_active',function($row){
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->rawColumns(['brand_image','action'])
            ->make(true);
    }
       public function add_product_category(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:product_categories,name',
                'is_active' => 'required|in:0,1',
            ]);
            $memberCategory = new \App\Models\ProductCategory();
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->save();
            return redirect()->route('admin.manage_product_categories')->with('success', 'Product Category added successfully.');
        }
        else{
            
            $currentPageName = 'Product Category';
            $addNewData = 'admin.add.product_category';
            $allData = 'admin.manage_product_categories';
            return view('admin.product-category-ops', compact('currentPageName', 'addNewData','allData'));
        }
        $currentPageName = 'Product Category';
        return view('admin.product-category-ops', compact('currentPageName', 'addNewData'));
    }
       public function add_temperature(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:temperatures,name',
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory = new \App\Models\Temperature();
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->save();
            return redirect()->route('admin.manage_temperatures')->with('success', 'Temperature added successfully.');
        }
        else{
            
            $currentPageName = 'Temperature';
            $addNewData = 'admin.add.temperature';
            $allData = 'admin.manage_temperatures';
            return view('admin.temperature-ops', compact('currentPageName', 'addNewData','allData'));
        }
        $currentPageName = 'Temperature';
        return view('admin.temperature-ops', compact('currentPageName', 'addNewData'));
    }
       public function addBrand(Request $request)
    {
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:brands,name',
                  'brand_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120',
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory = new \App\Models\Brand();
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->is_featured = 1;

             if (!empty($request->file('brand_image'))) {
                $path = 'images/brands/';
                $filePath = $this->storeImage($request->file('brand_image'), $path);
                $memberCategory->brand_image = $filePath;
            }
            $memberCategory->save();
            return redirect()->route('admin.manage_brands')->with('success', 'Brand added successfully.');
        }
        else{
            
            $currentPageName = 'Brand';
            $addNewData = 'admin.add.brand';
            $allData = 'admin.manage_brands';
            return view('admin.brand-ops', compact('currentPageName', 'addNewData','allData'));
        }
        $currentPageName = 'Brand';
        return view('admin.brand-ops', compact('currentPageName', 'addNewData'));
    }
        public function product_category_edit(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $memberCategory = \App\Models\ProductCategory::findOrFail($id);
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:product_categories,name,'.$memberCategory->id,
                'is_active' => 'required|in:0,1',
            ]);
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->save();
            return redirect()->route('admin.manage_product_categories')->with('success', 'Product Category updated successfully.');
        }
        else{
            
            $currentPageName = 'Product Category';
            $editData = 'admin.product_category.edit';
            $memberCategory->encrypted_id = $encrypted_id;
            $allData = 'admin.manage_product_categories';
            return view('admin.product-category-ops', compact('currentPageName', 'editData', 'memberCategory','allData'));
        }
    }
        public function temperature_edit(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $memberCategory = \App\Models\Temperature::findOrFail($id);
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:temperatures,name,'.$memberCategory->id,
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->save();
            return redirect()->route('admin.manage_temperatures')->with('success', 'Temperature updated successfully.');
        }
        else{
            
            $currentPageName = 'Temperature';
            $editData = 'admin.temperature.edit';
            $memberCategory->encrypted_id = $encrypted_id;
            $allData = 'admin.manage_temperatures';
            return view('admin.temperature-ops', compact('currentPageName', 'editData', 'memberCategory','allData'));
        }
    }
        public function brand_edit(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $memberCategory = \App\Models\Brand::findOrFail($id);
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required|unique:brands,name,'.$memberCategory->id,
                'is_active' => 'required|in:0,1'
            ]);
            $memberCategory->name = $request->name;
            $memberCategory->slug = \Str::slug($request->name);
            $memberCategory->is_active = $request->is_active == 1 ? true : false;
            $memberCategory->is_featured = 1;

             if (!empty($request->file('brand_image'))) {
                $path = 'images/brands/';
                $filePath = $this->storeImage($request->file("brand_image"), $path, $memberCategory->brand_image);
                $memberCategory->brand_image = $filePath;
            }
            $memberCategory->save();
            return redirect()->route('admin.manage_brands')->with('success', 'Brand updated successfully.');
        }
        else{
            
            $currentPageName = 'Brand';
            $editData = 'admin.brand.edit';
            $memberCategory->encrypted_id = $encrypted_id;
            $allData = 'admin.manage_brands';
            return view('admin.brand-ops', compact('currentPageName', 'editData', 'memberCategory','allData'));
        }
    }
      

    public function manageProductSubCategories()
    {
        $currentPageName = 'Product Sub-Categories';
        $currentPageData = 'product_sub_categories';
        $addNewData = 'admin.add.product_sub_category';
        $deleteUrl = 'admin.product_sub_category.delete';

        return view('admin.manage_product_sub_categories', compact('currentPageName', 'currentPageData', 'addNewData', 'deleteUrl'));
    }

    public function product_sub_category_data(Request $request)
    {
        $data = \App\Models\ProductSubCategory::with('productCategory')->latest()->get();

        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('category_name', function ($row) {
                return $row->productCategory ? e($row->productCategory->name) : '—';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.product_sub_category.edit', encrypt($row->id));
                $deleteId = encrypt($row->id);
                $model = 'ProductSubCategory';

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
            ->addColumn('is_active', function ($row) {
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function add_product_sub_category(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'product_category_id' => 'required|exists:product_categories,id',
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    \Illuminate\Validation\Rule::unique('product_sub_categories', 'name')->where('product_category_id', $request->product_category_id),
                ],
                'is_active' => 'required|in:0,1',
            ]);

            $row = new \App\Models\ProductSubCategory();
            $row->product_category_id = (int) $request->product_category_id;
            $row->name = $request->name;
            $row->slug = \Str::slug($request->name) . '-' . $row->product_category_id;
            $row->is_active = $request->is_active == 1;
            $row->save();

            return redirect()->route('admin.manage_product_sub_categories')->with('success', 'Product sub-category added successfully.');
        }

        $currentPageName = 'Product Sub-Category';
        $addNewData = 'admin.add.product_sub_category';
        $allData = 'admin.manage_product_sub_categories';
        $productCategories = \App\Models\ProductCategory::orderBy('name')->get();
        $subCategory = null;

        return view('admin.product-subcategory-ops', compact('currentPageName', 'addNewData', 'allData', 'productCategories', 'subCategory'));
    }

    public function product_sub_category_edit(Request $request, $encrypted_id)
    {
        $id = decrypt($encrypted_id);
        $subCategory = \App\Models\ProductSubCategory::findOrFail($id);

        if ($request->isMethod('post')) {
            $request->validate([
                'product_category_id' => 'required|exists:product_categories,id',
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    \Illuminate\Validation\Rule::unique('product_sub_categories', 'name')
                        ->where('product_category_id', $request->product_category_id)
                        ->ignore($subCategory->id),
                ],
                'is_active' => 'required|in:0,1',
            ]);

            $subCategory->product_category_id = (int) $request->product_category_id;
            $subCategory->name = $request->name;
            $subCategory->slug = \Str::slug($request->name) . '-' . $subCategory->product_category_id;
            $subCategory->is_active = $request->is_active == 1;
            $subCategory->save();

            return redirect()->route('admin.manage_product_sub_categories')->with('success', 'Product sub-category updated successfully.');
        }

        $currentPageName = 'Product Sub-Category';
        $editData = 'admin.product_sub_category.edit';
        $subCategory->encrypted_id = $encrypted_id;
        $allData = 'admin.manage_product_sub_categories';
        $productCategories = \App\Models\ProductCategory::orderBy('name')->get();

        return view('admin.product-subcategory-ops', compact('currentPageName', 'editData', 'subCategory', 'allData', 'productCategories'));
    }

      public function getBrands()
    {
        return \App\Models\Brand::where('is_active', 1)->where('is_featured', 1)->get();
    }

}
