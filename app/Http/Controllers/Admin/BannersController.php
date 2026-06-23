<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Banners;
use App\Models\Admin\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BannersController extends Controller
{
    function manageBanners()
    {
        $banners = Banners::select('id', 'position_order', 'banner_headline', 'status')->with('icons')->orderBy('position_order')->get();
        foreach ($banners as $banner) {
            $banner->encrypted_id = Crypt::encrypt($banner->id);
        }

        $model = Crypt::encrypt('Banners');
        $currentPage = "manage_banners";
        return view('admin.manage_banners', ['bannersData' => $banners, 'model' => $model, "currentPage" => $currentPage]);
    }

    function addBanner(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'banner_headline' => 'required',
                // 'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120',
                'banner_icons.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120'
            ], [
                'banner_headline.required' => 'Please upload a banner headline.',
                // 'banner_image.required' => 'Please upload a banner image.',
                // 'banner_image.image' => 'The banner must be a valid image file.',
                // 'banner_image.mimes' => 'Allowed banner image formats: jpeg, png, jpg, gif, webp, svg, bmp, tiff.',
                // 'banner_image.max' => 'The banner image size should not exceed 5MB.',
                'banner_icons.*.image' => 'Each banner icon must be a valid image file.',
                'banner_icons.*.mimes' => 'Allowed icon formats: jpeg, png, jpg, gif, webp, svg, bmp, tiff.',
                'banner_icons.*.max' => 'Each banner icon should not exceed 5MB.'
            ]);

            $order = Banners::max('position_order');
            $position_order = ($order !== null) ? $order + 1 : 1;

            $banner = [
                'position_order' => $position_order,
                'banner_title' => $request->banner_title,
                'banner_headline' => $request->banner_headline,
                'description' => htmlspecialchars($request->description, ENT_QUOTES),
                // 'button_name' => $request->button_name,
                // 'button_link' => $request->button_link,
                // 'other_button_name' => $request->other_button_name ?? '',
                // 'other_button_link' => $request->other_button_link ?? ''
            ];

            // $path = 'images/banners/';
            // $filePath = $this->storeImage($request->file('banner_image'), $path);
            // $banner['banner_image'] = $filePath;

            $banner_created = Banners::create($banner);
            if ($banner_created) {
                if ($request->hasFile('banner_icons')) {
                    $path = 'images/banners/';
                    foreach ($request->file('banner_icons') as $icon) {
                        $fileName = time() . '_' . uniqid() . '.' . $icon->getClientOriginalExtension();
                        $filePath = $path . $fileName;
                        $icon->move(public_path($path), $fileName);

                        $banner_created->icons()->create([
                            'reference_type' => 'banner',
                            'file_type'      => 'banner_icon',
                            'file_name'      => $fileName,
                            'file_path'      => $filePath,
                            'status'         => 'active'
                        ]);
                    }
                }
                session()->flash('success', 'Banner is inserted Successfully!');
                return redirect()->route('admin.manage_banners');
            } else {
                session()->flash('error', 'Insertion Error!');
                return redirect()->route('add.banner');
            }
        } else {
            $currentPage = "manage_banners";
            return view('admin.banner-ops', ["currentPage" => $currentPage]);
        }
    }

    function editBanner(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'banner_headline' => 'required',
                // 'banner_image' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120',
                'banner_icons.*' => 'image|mimes:jpeg,png,jpg,gif,webp,svg,bmp,tiff|max:5120'
            ], [
                'banner_headline.required' => 'Please upload a banner headline.',
                // 'banner_image.image' => 'The banner must be a valid image file.',
                // 'banner_image.mimes' => 'Allowed banner image formats: jpeg, png, jpg, gif, webp, svg, bmp, tiff.',
                // 'banner_image.max' => 'The banner image size should not exceed 5MB.',
                'banner_icons.*.image' => 'Each banner icon must be a valid image file.',
                'banner_icons.*.mimes' => 'Allowed icon formats: jpeg, png, jpg, gif, webp, svg, bmp, tiff.',
                'banner_icons.*.max' => 'Each banner icon should not exceed 5MB.'
            ]);

            $id = Crypt::decrypt($request->banner);
            $banner = Banners::findOrFail($id);
            $banner->banner_title = $request->banner_title;
            $banner->banner_headline = $request->banner_headline;
            $banner->description = htmlspecialchars($request->description, ENT_QUOTES);
            // $banner->button_name = $request->button_name;
            // $banner->button_link = $request->button_link;
            // $banner->other_button_name = $request->other_button_name ?? '';
            // $banner->other_button_link = $request->other_button_link ?? '';

            // if (!empty($request->file('banner_image'))) {
            //     $path = 'images/banners/';
            //     $filePath = $this->storeImage($request->file("banner_image"), $path, $banner->banner_image);
            //     $banner->banner_image = $filePath;
            // }

            if ($banner->save()) {
                if ($request->hasFile('banner_icons')) {
                    // $existingIcons = Images::where(["reference_id" => $id, "reference_type" => 'banner', "file_type" => 'banner_icon'])->get();
                    // foreach ($existingIcons as $existingIcon) {
                    //     $existingIconPath = public_path($existingIcon->file_path);
                    //     if (file_exists($existingIconPath)) {
                    //         unlink($existingIconPath);
                    //     }
                    //     $existingIcon->delete();
                    // }
                    foreach ($banner->icons as $icon) {
                        $iconFilePath = public_path($icon->file_path);
                        if (file_exists($iconFilePath)) unlink($iconFilePath);
                        $icon->delete();
                    }

                    $path = 'images/banners/';
                    foreach ($request->file('banner_icons') as $icon) {
                        $fileName = time() . '_' . uniqid() . '.' . $icon->getClientOriginalExtension();
                        $filePath = $path . $fileName;
                        $icon->move(public_path($path), $fileName);

                        $banner->icons()->create([
                            'reference_type' => 'banner',
                            'file_type'      => 'banner_icon',
                            'file_name'      => $fileName,
                            'file_path'      => $filePath,
                            'status'         => 'active'
                        ]);
                    }
                }
                session()->flash('success', 'Banner is updated Successfully!');
                return redirect()->route('admin.manage_banners');
            } else {
                session()->flash('error', 'Updation Error!');
                return redirect()->route('edit.banner', $request->banner);
            }
        } else {
            $id = Crypt::decrypt($request->banner);
            $banner = Banners::with('icons')->findOrFail($id);
            $banner->encrypted_id = $request->banner;

            $currentPage = "manage_banners";
            return view('admin.banner-ops', ["banner" => $banner, "currentPage" => $currentPage]);
        }
    }

    function getAllBanners()
    {
        $banners = Banners::with('icons')->where('status', 'active')->orderBy('position_order')->get();
        // foreach ($banners as $banner) {
        //     $banner->icons = Images::where('reference_id', $banner->id)->get();
        // }

        return $banners;
    }
}
