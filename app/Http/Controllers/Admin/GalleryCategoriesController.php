<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\GalleryCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class GalleryCategoriesController extends Controller
{
    public function manageGalleryCategories()
    {
        $currentPage = 'manage_gallery_categories';
        $model = Crypt::encrypt('GalleryCategories');
        return view('admin.manage_gallery_categories', compact('currentPage', 'model'));
    }

    public function gallery_category_data()
    {
        $data = GalleryCategories::select('id', 'name', 'slug', 'show_header', 'is_active', 'position_order')
            ->orderBy('position_order')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('show_header', function ($row) {
                return $row->show_header ? 'Yes' : 'No';
            })
            ->addColumn('is_active', function ($row) {
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($row) {
                $encryptedId = Crypt::encrypt($row->id);
                $model = Crypt::encrypt('GalleryCategories');
                return '<div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="' . route('admin.edit.gallery_category', encrypt($row->id)) . '" class="dropdown-item">Modify</a>
                                <button class="dropdown-item delete"
                                    onclick="delete_item(\'' . $model . '\', \'' . $encryptedId . '\');"
                                    data-id="' . $row->id . '">
                                    Delete
                                </button>
                            </div>
                        </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function addGalleryCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:gallery_categories,slug',
                'show_header' => 'required|in:0,1',
                'is_active' => 'required|in:0,1',
            ]);

            $order = GalleryCategories::max('position_order');
            $position_order = ($order !== null) ? $order + 1 : 1;

            $slug = $this->uniqueCategorySlug(
                !empty($request->slug) ? $request->slug : $request->name
            );

            if (GalleryCategories::create([
                'name' => $request->name,
                'slug' => $slug,
                'show_header' => $request->show_header == 1,
                'is_active' => $request->is_active == 1,
                'position_order' => $position_order,
            ])) {
                session()->flash('success', 'Gallery category added successfully!');
                return redirect()->route('admin.manage_gallery_categories');
            }

            session()->flash('error', 'Insertion error!');
            return redirect()->route('admin.add.gallery_category');
        }

        $currentPage = 'manage_gallery_categories';
        return view('admin.gallery-category-ops', compact('currentPage'));
    }

    public function editGalleryCategory(Request $request)
    {
        if ($request->isMethod('post')) {
            $id = Crypt::decrypt($request->gallery_category);
            $category = GalleryCategories::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:gallery_categories,slug,' . $category->id,
                'show_header' => 'required|in:0,1',
                'is_active' => 'required|in:0,1',
            ]);

            $category->name = $request->name;
            $category->slug = $this->uniqueCategorySlug(
                !empty($request->slug) ? $request->slug : $request->name,
                $category->id
            );
            $category->show_header = $request->show_header == 1;
            $category->is_active = $request->is_active == 1;
            $category->position_order = $request->position_order ?? $category->position_order;

            if ($category->save()) {
                session()->flash('success', 'Gallery category updated successfully!');
                return redirect()->route('admin.manage_gallery_categories');
            }

            session()->flash('error', 'Update error!');
            return redirect()->route('admin.edit.gallery_category', $request->gallery_category);
        }

        $id = Crypt::decrypt($request->gallery_category);
        $category = GalleryCategories::where('id', $id)->firstOrFail();
        $category->encrypted_id = $request->gallery_category;
        $currentPage = 'manage_gallery_categories';
        return view('admin.gallery-category-ops', compact('category', 'currentPage'));
    }

    private function uniqueCategorySlug(string $value, int $excludeId = 0): string
    {
        $slug = Str::slug(strtolower($value));
        $original = $slug;
        $suffix = 1;

        while (true) {
            $query = GalleryCategories::where('slug', $slug);
            if ($excludeId > 0) {
                $query->where('id', '!=', $excludeId);
            }
            if ($query->count() === 0) {
                break;
            }
            $slug = $original . '-' . $suffix;
            $suffix++;
        }

        return $slug;
    }
}
