<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Galleries;
use App\Models\Admin\GalleryCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class GalleriesController extends Controller
{
    public function manageGalleries()
    {
        $currentPage = 'manage_galleries';
        $model = Crypt::encrypt('Galleries');
        return view('admin.manage_galleries', compact('currentPage', 'model'));
    }

    public function gallery_data()
    {
        $data = Galleries::select(
            'galleries.id',
            'galleries.title',
            'galleries.slug',
            'galleries.image',
            'galleries.is_feature',
            'galleries.is_active',
            'galleries.position_order',
            'gallery_categories.name as category_name'
        )
            ->join('gallery_categories', 'gallery_categories.id', '=', 'galleries.gallery_category_id')
            ->orderBy('galleries.position_order')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    return '<img src="' . asset($row->image) . '" alt="' . e($row->title) . '" width="60" height="60" class="rounded" style="object-fit:cover;">';
                }
                return '';
            })
            ->addColumn('is_feature', function ($row) {
                return $row->is_feature ? 'Yes' : 'No';
            })
            ->addColumn('is_active', function ($row) {
                return $row->is_active ? 'Active' : 'Inactive';
            })
            ->addColumn('action', function ($row) {
                $encryptedId = Crypt::encrypt($row->id);
                $model = Crypt::encrypt('Galleries');
                return '<div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="' . route('admin.edit.gallery', encrypt($row->id)) . '" class="dropdown-item">Modify</a>
                                <button class="dropdown-item delete"
                                    onclick="delete_item(\'' . $model . '\', \'' . $encryptedId . '\');"
                                    data-id="' . $row->id . '">
                                    Delete
                                </button>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'image'])
            ->make(true);
    }

    public function addGallery(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:galleries,slug',
                'short_description' => 'nullable|string',
                'gallery_category' => 'required|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'is_feature' => 'required|in:0,1',
                'is_active' => 'required|in:0,1',
            ]);

            $order = Galleries::max('position_order');
            $position_order = ($order !== null) ? $order + 1 : 1;

            $slug = $this->uniqueGallerySlug(
                !empty($request->slug) ? $request->slug : $request->title
            );

            $gallery = [
                'gallery_category_id' => Crypt::decrypt($request->gallery_category),
                'title' => $request->title,
                'slug' => $slug,
                'short_description' => htmlspecialchars($request->short_description ?? '', ENT_QUOTES),
                'is_feature' => $request->is_feature == 1,
                'is_active' => $request->is_active == 1,
                'position_order' => $position_order,
            ];

            if (!empty($request->file('image'))) {
                $path = 'images/gallery/';
                $filePath = $this->storeImage($request->file('image'), $path);
                $gallery['image'] = $filePath;
            }

            if (Galleries::create($gallery)) {
                session()->flash('success', 'Gallery item added successfully!');
                return redirect()->route('admin.manage_galleries');
            }

            session()->flash('error', 'Insertion error!');
            return redirect()->route('admin.add.gallery');
        }

        $categories = GalleryCategories::where('is_active', true)->orderBy('position_order')->get();
        foreach ($categories as $category) {
            $category->encrypted_id = Crypt::encrypt($category->id);
        }
        $currentPage = 'manage_galleries';
        return view('admin.gallery-ops', compact('categories', 'currentPage'));
    }

    public function editGallery(Request $request)
    {
        if ($request->isMethod('post')) {
            $id = Crypt::decrypt($request->gallery);
            $gallery = Galleries::findOrFail($id);

            $request->validate([
                'title' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:galleries,slug,' . $gallery->id,
                'short_description' => 'nullable|string',
                'gallery_category' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'is_feature' => 'required|in:0,1',
                'is_active' => 'required|in:0,1',
            ]);

            $gallery->gallery_category_id = Crypt::decrypt($request->gallery_category);
            $gallery->title = $request->title;
            $gallery->slug = $this->uniqueGallerySlug(
                !empty($request->slug) ? $request->slug : $request->title,
                $gallery->id
            );
            $gallery->short_description = htmlspecialchars($request->short_description ?? '', ENT_QUOTES);
            $gallery->is_feature = $request->is_feature == 1;
            $gallery->is_active = $request->is_active == 1;
            $gallery->position_order = $request->position_order ?? $gallery->position_order;

            if (!empty($request->file('image'))) {
                $path = 'images/gallery/';
                $filePath = $this->storeImage($request->file('image'), $path, $gallery->image);
                $gallery->image = $filePath;
            }

            if ($gallery->save()) {
                session()->flash('success', 'Gallery item updated successfully!');
                return redirect()->route('admin.manage_galleries');
            }

            session()->flash('error', 'Update error!');
            return redirect()->route('admin.edit.gallery', $request->gallery);
        }

        $id = Crypt::decrypt($request->gallery);
        $gallery = Galleries::where('id', $id)->firstOrFail();
        $gallery->encrypted_id = $request->gallery;

        $categories = GalleryCategories::where('is_active', true)
            ->orWhere('id', $gallery->gallery_category_id)
            ->orderBy('position_order')
            ->get();
        foreach ($categories as $category) {
            $category->encrypted_id = Crypt::encrypt($category->id);
        }

        $currentPage = 'manage_galleries';
        return view('admin.gallery-ops', compact('gallery', 'categories', 'currentPage'));
    }

    private function uniqueGallerySlug(string $value, int $excludeId = 0): string
    {
        $slug = Str::slug(strtolower($value));
        $original = $slug;
        $suffix = 1;

        while (true) {
            $query = Galleries::where('slug', $slug);
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
