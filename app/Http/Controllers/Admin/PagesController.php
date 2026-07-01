<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Pages;
use App\Models\Admin\PageSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PagesController extends Controller
{
    function getPagesPage()
    {
        $all_pages = Pages::select('id', 'position_order', 'page_name')->orderBy('position_order')->get();
        foreach ($all_pages as $page) {
            $page->encrypted_id = Crypt::encrypt($page->id);
        }

        $currentPage = "manage_pages";
        return view('admin.page_sequences_ops', ["pagesData" => $all_pages, 'currentPage' => $currentPage]);
    }


    public function pages_data() {
        
          $pages = Pages::query();
          $model = Crypt::encrypt('Pages');
                return DataTables::of($pages)
            ->addIndexColumn()
            ->addColumn('page_name', function($pages){
                return $pages->page_name;
            })
            ->addColumn('position_order', function($pages){
                return $pages->position_order? $pages->position_order : ''; 
            })
          ->addColumn('client_page_url', function($pages) {
                if (
                    empty($pages->client_page_urls) ||
                    $pages->client_page_urls == 'index' ||
                    $pages->client_page_urls == 'home'
                ) {
                    $client_url = '/';
                } else {
                    $client_url = '/' . $pages->client_page_urls;
                }

                return '<a href="' . $client_url . '">
                            <small><strong>' . e($pages->header_footer_name) . '</strong></small>
                        </a>';
            })
            ->addColumn('visibility', function ($pages) use ($model) {
                $encryptedId = Crypt::encrypt($pages->id);
                $sno = 1;

                if ($pages->id == 1 && Auth::guard('admin')->user()->role != 1) {
                    return '-';
                }

                $selectedHeader = $pages->visibility == 'header' ? 'selected' : '';
                $selectedFooter = $pages->visibility == 'footer' ? 'selected' : '';
                $selectedBoth   = $pages->visibility == 'both'   ? 'selected' : '';
                $selectedNone   = $pages->visibility == 'none'   ? 'selected' : '';

                return '<select
                            onchange="change_visibility(\'' . $model . '\', ' . $pages->id . ', \'' . $encryptedId . '\');"
                            id="visibility' . $pages->id . '"
                            class="form-select form-select-sm">
                            <option value="header" ' . $selectedHeader . '>HEADER</option>
                            <option value="footer" ' . $selectedFooter . '>FOOTER</option>
                            <option value="both"   ' . $selectedBoth   . '>BOTH</option>
                            <option value="none"   ' . $selectedNone   . '>NONE</option>
                        </select>
                        <div class="text-danger small" id="visibility_error_' . $pages->id . '"></div>';
            })

            ->addColumn('is_active', function($pages){
                return $pages->status == 'active' ? 'Active' : 'In active';
            })
            ->addColumn('action', function ($pages) {
                   $encryptedId = Crypt::encrypt($pages->id);
                $model = Crypt::encrypt('Pages');
                return '<div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="' . route('admin.edit.page', encrypt($pages->id)) . '" class="dropdown-item">Modify</a>
                                 <button class="dropdown-item delete"
                                    onclick="delete_item(\'' . $model . '\', \'' . $encryptedId . '\');"
                                    data-id="' . $pages->id . '">
                                Delete 
                            </button>
                            </div>
                        </div>';
            })
            ->rawColumns(['client_page_url', 'visibility', 'action'])
            ->make(true);
    
    }

    function savePagesSequence(Request $request)
    {
        if (isset($request->page_ids) && count($request->page_ids) > 0) {
            if (isset($request->sequences) && count($request->sequences) > 0) {
                $sequences = $request->sequences;
            } else {
                $sequences = ["1"];
            }
        }
        $executions = 0;

        if (isset($sequences) && count($sequences) > 0) {
            $encrypted_ids = $request->page_ids;
            foreach ($encrypted_ids as $key => $encrypted_id) {
                $id = Crypt::decrypt($encrypted_id);
                $sequence = $sequences[$key];

                $page = Pages::findOrFail($id);
                $page->position_order = $sequence;
                $page->save();
                $executions += 1;
            }
            if ($executions == 0) {
                $request->session()->flash('error', 'Can\'t update the data!');
                return redirect()->route('admin.get.pages.page');
            } else {
                $request->session()->flash('success', 'Sequence is updated Successfully!');
                return redirect()->route('admin.manage_pages');
            }
        } else {
            $request->session()->flash('error', 'Data is not there!');
            return redirect()->route('admin.get.pages.page');
        }
    }

    function managePages()
    {
        $pages = Pages::select('id', 'position_order', 'page_name', 'header_footer_name', 'client_page_urls', 'visibility', 'status')->orderBy('position_order')->get();
        foreach ($pages as $page) {
            $page->encrypted_id = Crypt::encrypt($page->id);
        }
        $currentPage = "manage_pages";
        $model = Crypt::encrypt('Pages');
        return view('admin.manage_pages', ['pagesData' => $pages, 'model' => $model, 'currentPage' => $currentPage]);
    }

    function addPage(Request $request)
    {
        if (Auth::guard('admin')->user()->role == 1) {
            if ($request->isMethod('post')) {
                $request->validate([
                    'header_footer_name' => 'required|string',
                    'page_name' => 'required|string'
                ], [
                    'header_footer_name.required' => 'Header/Footer name is required!',
                    'header_footer_name.string' => 'Header/Footer name must be a string!',
                    'page_name.required' => 'Page name is required!',
                    'page_name.string' => 'Page name must be a string!'
                ]);

                $page_order = Pages::max('position_order');
                $position_order = ($page_order !== null) ? $page_order + 1 : 1;

                $page = [
                    'position_order' => $position_order,
                    'page_name' => $request->page_name,
                    'client_page_urls' => $request->client_page_link,
                    'header_footer_name' => $request->header_footer_name,
                    'page_headline' => $request->page_headline,
                     'video_link' => $request->video_link,
                    'visibility' => 'none', 
                    'breadcrumb_headline' => $request->breadcrumb_headline,
                    'breadcrumb_description' => htmlspecialchars($request->breadcrumb_description, ENT_QUOTES),
                    'description' => htmlspecialchars($request->description, ENT_QUOTES),
                    'status' => $request->status,
                    'meta_title' => $request->meta_title,
                    'meta_keyword' => $request->meta_keyword,
                    'meta_description' => htmlspecialchars($request->meta_description, ENT_QUOTES),
                ];
                if (!empty($request->file('page_image'))) {
                    $path = 'images/pages/';
                    $filePath = $this->storeImage($request->file('page_image'), $path);
                    $page['page_image'] = $filePath;
                }

                if (Pages::create($page)) {
                    $request->session()->flash('success', 'Page is created Successfully!');
                    return redirect()->route('admin.manage_pages');
                } else {
                    $request->session()->flash('error', 'Creation Error!');
                    return redirect()->route('admin.add.page');
                }
            } else {
                $section_enc_id = Crypt::encrypt(0);
                $currentPage = "manage_pages";
                return view('admin.page-ops', ["section_enc_id" => $section_enc_id, 'currentPage' => $currentPage]);
            }
        }
    }

    function editPage(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'header_footer_name' => 'required|string',
                'page_name' => 'required|string'
            ], [
                'header_footer_name.required' => 'Header/Footer name is required!',
                'header_footer_name.string' => 'Header/Footer name must be a string!',
                'page_name.required' => 'Page name is required!',
                'page_name.string' => 'Page name must be a string!'
            ]);

            $id = Crypt::decrypt($request->page);
            $page = Pages::findOrFail($id);
            if (session('role') == 'superadmin') {
                $page->client_page_urls = Slug::str($request->client_page_link);
            }
            $page->page_name = $request->page_name;
            $page->header_footer_name = $request->header_footer_name;
            $page->page_headline = $request->page_headline;
            $page->breadcrumb_headline = $request->breadcrumb_headline;
            $page->video_link = $request->video_link;
            $page->breadcrumb_description = htmlspecialchars($request->breadcrumb_description, ENT_QUOTES);
            $page->description = htmlspecialchars($request->description, ENT_QUOTES);
            $page->status = $request->status;
            $page->meta_title = $request->meta_title;
            $page->meta_keyword = $request->meta_keyword;
            $page->meta_description = htmlspecialchars($request->meta_description, ENT_QUOTES);
            if (!empty($request->file('page_image'))) {
                $path = 'images/pages/';
                $filePath = $this->storeImage($request->file("page_image"), $path, $page->page_image);
                $page->page_image = $filePath;
            }

            if ($page->save()) {
                $request->session()->flash('success', 'Page is updated Successfully!');
                return redirect()->route('admin.manage_pages');
            } else {
                $request->session()->flash('error', 'Updation Error!');
                return redirect()->route('admin.edit.page', $request->page);
            }
        } else {
            $page = Pages::where('id', Crypt::decrypt($request->page))->firstOrFail();
            $page->encrypted_id = $request->page;
            $sections = PageSections::where(['page_id' => Crypt::decrypt($request->page), 'parent_id' => null])->orderBy('position_order')->get();
            foreach ($sections as $section) {
                $section->encrypted_id = Crypt::encrypt($section->id);
            }

            $section_enc_id = Crypt::encrypt(0);
            $currentPage = "manage_pages";
            $model = Crypt::encrypt('PageSections');
            return view('admin.page-ops', ["section_enc_id" => $section_enc_id, 'page' => $page, 'sectionsData' => $sections, 'model' => $model, 'currentPage' => $currentPage]);
        }
    }

    function getSectionsPage(Request $request)
    {
        if ($request->section == 0) {
            $sections_data = PageSections::select('id', 'position_order', 'section_headline')->where(['page_id' => Crypt::decrypt($request->page), 'parent_id' => null])->orderBy('position_order')->get();
            foreach ($sections_data as $section) {
                $section->encrypted_id = Crypt::encrypt($section->id);
            }
        } else {
            $sections_data = PageSections::select('id', 'position_order', 'section_headline')->where(['page_id' => Crypt::decrypt($request->page), 'parent_id' => Crypt::decrypt($request->section)])->orderBy('position_order')->get();
            foreach ($sections_data as $subsection) {
                $subsection->encrypted_id = Crypt::encrypt($subsection->id);
            }
        }

        $currentPage = "manage_pages";
        return view('admin.section_sequences_ops', ["sectionsData" => $sections_data, "page_enc_id" => $request->page, "section_enc_id" => $request->section, 'currentPage' => $currentPage]);
    }


    public function pagesection_data(Request $request) {
        
    $encryptpageid = $request->page_id;
    $id =  Crypt::decrypt($request->page_id);
    
          $pages = PageSections::where(['page_id' => $id, 'parent_id' => null])->orderBy('position_order')->get();
          $model = Crypt::encrypt('Pages');
                return DataTables::of($pages)
            ->addIndexColumn()
            ->addColumn('section_title', function($pages){
                return $pages->section_title;
            })
            ->addColumn('section_headline', function($pages){
                return $pages->section_headline;
            })
            ->addColumn('position_order', function($pages){
                return $pages->position_order? $pages->position_order : ''; 
            })
            ->addColumn('section_image', function ($sections) {
                if (empty($sections->section_image)) {
                    return '-'; // or empty string
                }

                $imgUrl = asset($sections->section_image);
                $alt    = $sections->section_headline ?? 'Image';

                return '<a href="javascript:void(0)" class="hstack gap-3">
                            <div class="avatar-image avatar-md">
                                <img src="' . e($imgUrl) . '"
                                    alt="' . e($alt) . '"
                                    class="img-fluid">
                            </div>
                        </a>';
            })
                ->addColumn('more_images', function ($sections) {
                    $moreImages = json_decode($sections->more_images);

                    if (empty($moreImages)) {
                        return '-';
                    }

                    $html = '<ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                <div class="img-group lh-0 ms-3 justify-content-start d-none d-sm-flex">';
                    foreach ($moreImages as $image) {
                        $imgUrl = asset($image);
                        $alt    = $sections->section_headline ?? 'Image';
                        $html .= '<a href="javascript:void(0)"
                                    class="avatar-image avatar-md"
                                    data-bs-toggle="tooltip"
                                    data-bs-trigger="hover"
                                    title="' . e($alt) . '">
                                    <img src="' . e($imgUrl) . '"
                                        class="img-fluid"
                                        alt="' . e($alt) . '" />
                                </a>';
                    }
                    $html .= '</div></ul>';

                    return $html;
                })
            ->addColumn('is_active', function($pages){
                return $pages->status == 'active' ? 'Active' : 'In active';
            })
            ->addColumn('action', function ($pages) use ($id, $model, $encryptpageid) {
            $encryptedId = Crypt::encrypt($pages->id); 
            $pageid = $id;
                $model = Crypt::encrypt('PageSections');
                return '<div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a  href="' . route('admin.edit.page.section', [
                           'page'=> $encryptpageid,'section' => $encryptedId]) . '" class="dropdown-item">Modify</a>
                                 <button class="dropdown-item delete"
                                    onclick="delete_item(\'' . $model . '\', \'' . $encryptedId . '\');"
                                    data-id="' . $pages->id . '">
                                Delete 
                            </button>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'section_image', 'more_images'])
            ->make(true);
    
    }

    function saveSectionsSequence(Request $request)
    {
        $page_id = Crypt::decrypt($request->page);
        if (isset($request->section) && !empty($request->section)) {
            $section_id = Crypt::decrypt($request->section);
        } else {
            $section_id = 0;
        }
        if (isset($request->section_ids) && count($request->section_ids) > 0) {
            if (isset($request->sequences) && count($request->sequences) > 0) {
                $sequences = $request->sequences;
            } else {
                $sequences = ["1"];
            }
        }
        $executions = 0;

        if (isset($sequences) && count($sequences) > 0) {
            $encrypted_ids = $request->section_ids;
            foreach ($encrypted_ids as $key => $encrypted_id) {
                $id = Crypt::decrypt($encrypted_id);
                $sequence = $sequences[$key];

                if ($section_id != 0) {
                    $section = PageSections::where(["id" => $id, "page_id" => $page_id, "parent_id" => $section_id])->first();
                } else {
                    $section = PageSections::where(["id" => $id, "page_id" => $page_id, "parent_id" => null])->first();
                }
                $section->position_order = $sequence;
                $section->save();
                $executions += 1;
            }
            if ($executions == 0) {
                $request->session()->flash('error', 'Can\'t update the data!');
                return redirect()->route('admin.get.sections.page', ["page" => $request->page, "section" => $request->section]);
            } else {
                $request->session()->flash('success', 'Sequence is updated Successfully!');
                if ($section_id != 0) {
                    return redirect()->route('admin.edit.page.section', ["page" => $request->page, "section" => $request->section]);
                } else {
                    return redirect()->route('admin.edit.page', ["page" => $request->page, "section" => $request->section]);
                }
            }
        } else {
            $request->session()->flash('error', 'Data is not there!');
            return redirect()->route('admin.get.sections.page', ["page" => $request->page, "section" => $request->section]);
        }
    }

    function addPageSection(Request $request)
    {
        if (Auth::guard('admin')->user()->role == 1) {
            if ($request->isMethod('post')) {
                $request->validate([
                    'default_section_name' => 'required|string',
                    // 'section_headline' => 'required|string',
                    // 'section_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                ], [
                    // 'default_section_name.required' => 'Default section name is required!',
                    // 'default_section_name.string' => 'Default section name must be a string!',
                    // 'section_headline.required' => 'Section headline is required!',
                    // 'section_headline.string' => 'Section headline must be a string!',
                    // 'section_image.image' => 'The file must be an image!',
                    // 'section_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                    // 'section_image.max' => 'The image must not be larger than 2MB!'
                ]);

                $page_id = Crypt::decrypt($request->page);
                $section_order = PageSections::where(["page_id" => $page_id, "parent_id" => null])->max('position_order');
                $position_order = ($section_order !== null) ? $section_order + 1 : 1;

                $section = [
                    'page_id' => $page_id,
                    'default_section_name' => $request->default_section_name,
                    'position_order' => $position_order,
                    'section_title' => $request->section_title,
                    'section_headline' => $request->section_headline,
                    'section_subtitle' => $request->section_subtitle,
                    'description' => htmlspecialchars($request->description, ENT_QUOTES),
                    'button_name' => $request->button_name,
                    'button_link' => $request->button_link,
                    'video_link' => $request->video_link,
                    'status' => $request->status,
                ];
                if (!empty($request->file('section_image'))) {
                    $path = 'images/pages/sections/';
                    $filePath = $this->storeImage($request->file("section_image"), $path);
                    $section['section_image'] = $filePath;
                }

                $image_paths = [];
                if ($request->hasFile('more_images')) {
                    $path = 'images/pages/sections/';
                    foreach ($request->file('more_images') as $file) {
                        $filePath = $this->storeImage($file, $path);
                        $image_paths[] = $filePath;
                    }
                    $section['more_images'] = json_encode($image_paths);
                }

                if (PageSections::create($section)) {
                    $request->session()->flash('success', 'Section is inserted Successfully!');
                    return redirect()->route('admin.edit.page', $request->page);
                } else {
                    $request->session()->flash('error', 'Insertion Error!');
                    return redirect()->route('admin.add.page.section', $request->page);
                }
            } else {
                $currentPage = "manage_pages";
                return view('admin.page-section-ops', ["page_enc_id" => $request->page, 'currentPage' => $currentPage]);
            }
        }
    }

    function editPageSection(Request $request)
    {
        // dd($request->all());
        if ($request->isMethod('post')) {
            if (session('role') == 'superadmin') {
                $request->validate([
                    'default_section_name' => 'required|string',
                    // 'section_headline' => 'required|string',
                    // 'section_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                ], [
                    'default_section_name.required' => 'Default section name is required!',
                    'default_section_name.string' => 'Default section name must be a string!',
                    // 'section_headline.required' => 'Section headline is required!',
                    // 'section_headline.string' => 'Section headline must be a string!',
                    // 'section_image.image' => 'The file must be an image!',
                    // 'section_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                    // 'section_image.max' => 'The image must not be larger than 2MB!'
                ]);
            } elseif (session('role') == 'admin') {
                $request->validate([
                    // 'section_headline' => 'required|string',
                    // 'section_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                ], [
                    // 'section_headline.required' => 'Section headline is required!',
                    // 'section_headline.string' => 'Section headline must be a string!',
                    // 'section_image.image' => 'The file must be an image!',
                    // 'section_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                    // 'section_image.max' => 'The image must not be larger than 2MB!'
                ]);
            }

            $id = Crypt::decrypt($request->section);
            $section = PageSections::findOrFail($id);
            if (session('role') == 'superadmin') {
                $section->default_section_name = $request->default_section_name;
            }
            $section->section_title = $request->section_title;
            $section->section_headline = $request->section_headline;
            $section->section_subtitle = $request->section_subtitle;
            $section->description = htmlspecialchars($request->description, ENT_QUOTES);
            $section->button_name = $request->button_name;
            $section->button_link = $request->button_link;
            $section->status = $request->status;
            $section->video_link = $request->video_link;
            $section->faq_id = $request->has('faq_ids') 
            ? json_encode($request->faq_ids) 
            : null;
            if (!empty($request->file('section_image'))) {
                $path = 'images/pages/sections/';
                $filePath = $this->storeImage($request->file("section_image"), $path, $section->section_image);
                $section->section_image = $filePath;
            }

         $image_paths = [];

if ($request->hasFile('more_images')) {

    $more_images = json_decode($section->more_images, true) ?? [];

    // delete old images safely
    foreach ($more_images as $image) {
        $this->removeImage($image);
    }

    $path = 'images/pages/sections/';

    foreach ($request->file('more_images') as $file) {
        $filePath = $this->storeImage($file, $path);
        $image_paths[] = $filePath;
    }

    $section->more_images = json_encode($image_paths, JSON_HEX_APOS | JSON_HEX_QUOT);
}

            if ($section->save()) {
                $request->session()->flash('success', 'Section is updated Successfully!');
                return redirect()->route('admin.edit.page.section', ["page" => $request->page, "section" => $request->section]);
            } else {
                $request->session()->flash('error', 'Updation Error!');
                return redirect()->route('admin.edit.page.section', ["page" => $request->page, "section" => $request->section]);
            }
        } else {

        // dd(Crypt::decrypt($request->page));
            $section = PageSections::where('id', Crypt::decrypt($request->section))->firstOrFail();
            $section->encrypted_id = $request->section;
            $subsections = PageSections::where(['page_id' => Crypt::decrypt($request->page), 'parent_id' => Crypt::decrypt($request->section)])->orderBy('position_order')->get();
            foreach ($subsections as $subsection) {
                $subsection->encrypted_id = Crypt::encrypt($subsection->id);
            }
            $currentPage = "manage_pages";
            $model = Crypt::encrypt('PageSections');
            return view('admin.page-section-ops', ['section' => $section, "page_enc_id" => $request->page, 'subSectionsData' => $subsections, 'model' => $model, 'currentPage' => $currentPage]);
        }
    }

    function addPageSubSection(Request $request)
    {
        if ($request->isMethod('post')) {
            if (session('role') == 'superadmin') {
                $request->validate([
                    'default_subsection_name' => 'required|string',
                    // 'subsection_headline' => 'required|string',
                    // 'subsection_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                ], [
                    'default_subsection_name.required' => 'Default section name is required!',
                    'default_subsection_name.string' => 'Default section name must be a string!',
                    // 'subsection_headline.required' => 'Section headline is required!',
                    // 'subsection_headline.string' => 'Section headline must be a string!',
                    // 'subsection_image.image' => 'The file must be an image!',
                    // 'subsection_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                    // 'subsection_image.max' => 'The image must not be larger than 2MB!'
                ]);
            } elseif (session('role') == 'admin') {
                $request->validate([
                    // 'subsection_headline' => 'required|string',
                    // 'subsection_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                ], [
                    // 'subsection_headline.required' => 'Section headline is required!',
                    // 'subsection_headline.string' => 'Section headline must be a string!',
                    // 'subsection_image.image' => 'The file must be an image!',
                    // 'subsection_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                    // 'subsection_image.max' => 'The image must not be larger than 2MB!'
                ]);
            }

            $page_id = Crypt::decrypt($request->page);
            $section_id = Crypt::decrypt($request->section);
            $subsection_order = PageSections::where(["page_id" => $page_id, "parent_id" => $section_id])->max('position_order');
            $position_order = ($subsection_order !== null) ? $subsection_order + 1 : 1;

            $subsection = [
                'page_id' => $page_id,
                'parent_id' => $section_id,
                'position_order' => $position_order,
                'section_title' => $request->subsection_title,
                'section_headline' => $request->subsection_headline,
                'section_subheading' => $request->section_subheading,
                'section_subtitle' => $request->section_subtitle,
                'button_link' => $request->button_link,
                'status' => $request->status,
                'description' => htmlspecialchars($request->description, ENT_QUOTES)
            ];
            if (session('role') == 'superadmin') {
                $subsection['default_section_name'] = $request->default_subsection_name;
            }
            if (!empty($request->file('subsection_image'))) {
                $path = 'images/pages/sections/';
                $filePath = $this->storeImage($request->file("subsection_image"), $path);
                $subsection['section_image'] = $filePath;
            }

            if (!empty($request->file('more_images'))) {
                $path = 'images/pages/sections/';
                $filePath = $this->storeImage($request->file("more_images"), $path);
                $subsection['more_images']= $filePath;
            }
            
            if (PageSections::create($subsection)) {
                $request->session()->flash('success', 'Sub-Section is inserted Successfully!');
                return redirect()->route('admin.edit.page.section', ["page" => $request->page, "section" => $request->section]);
            } else {
                $request->session()->flash('error', 'Insertion Error!');
                return redirect()->route('admin.add.page.subsection', ["page" => $request->page, "section" => $request->section]);
            }
        } else {
            $currentPage = "manage_pages";
            return view('admin.page-subsection-ops', ["page_enc_id" => $request->page, "section_enc_id" => $request->section, 'currentPage' => $currentPage]);
        }
    }

    function editPageSubSection(Request $request)
    {
        if ($request->isMethod('post')) {
            if (session('role') == 'superadmin') {
                $request->validate([
                    'default_subsection_name' => 'required|string',
                    'subsection_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                ], [
                    'default_subsection_name.required' => 'Default section name is required!',
                    'default_subsection_name.string' => 'Default section name must be a string!',
                    'subsection_image.image' => 'The file must be an image!',
                    'subsection_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                    'subsection_image.max' => 'The image must not be larger than 2MB!'
                ]);
            } elseif (session('role') == 'admin') {
                $request->validate([
                    'subsection_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
                ], [
                    'subsection_image.image' => 'The file must be an image!',
                    'subsection_image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                    'subsection_image.max' => 'The image must not be larger than 2MB!'
                ]);
            }

            $id = Crypt::decrypt($request->subsection);
            $subsection = PageSections::findOrFail($id);
            if (session('role') == 'superadmin') {
                $subsection->default_section_name = $request->default_subsection_name;
            }
            $subsection->section_title = $request->subsection_title;
            $subsection->section_headline = $request->subsection_headline;
            $subsection->section_subheading = $request->section_subheading;
              $subsection->button_name = $request->button_name;
             $subsection->button_link = $request->button_link;
             $subsection->section_subtitle = $request->section_subtitle;
            $subsection->description = htmlspecialchars($request->description, ENT_QUOTES);
            $subsection->status = $request->status;
            if (!empty($request->file('subsection_image'))) {
                $path = 'images/pages/sections/';
                $filePath = $this->storeImage($request->file("subsection_image"), $path, $subsection->section_image);
                $subsection->section_image = $filePath;
            }

             if (!empty($request->file('more_images'))) {
                $path = 'images/pages/sections/';
                $filePath = $this->storeImage($request->file("more_images"), $path, $subsection->more_images);
                $subsection->more_images = $filePath;
            }

            if ($subsection->save()) {
                $request->session()->flash('success', 'Sub-Section is updated Successfully!');
                return redirect()->route('admin.edit.page.subsection', ["page" => $request->page, "section" => $request->section, "subsection" => $request->subsection]);
            } else {
                $request->session()->flash('error', 'Updation Error!');
                return redirect()->route('admin.edit.page.subsection', ["page" => $request->page, "section" => $request->section, "subsection" => $request->subsection]);
            }
        } else {
            //  dd(Crypt::decrypt($request->page));
            $subsection = PageSections::where('id', Crypt::decrypt($request->subsection))->firstOrFail();
            $subsection->encrypted_id = $request->subsection;
            $currentPage = "manage_pages";
            return view('admin.page-subsection-ops', ['subsection' => $subsection, "page_enc_id" => $request->page, "section_enc_id" => $request->section, 'currentPage' => $currentPage]);
        }
    }

    function getAllPages()
    {
        return Pages::where(["status" => 'active'])->orderBy("position_order")->get();
    }

    function getPage($page_url)
    {
        return Pages::where(["client_page_urls" => $page_url])->first();
    }

   public function getPageSection($section_id)
{
    $page_section = PageSections::where('status', 'active')
                                  ->where('id', $section_id)
                                  ->first();

    if (!$page_section) {
        return null; // or return new PageSections(); if you prefer
    }

    $page_section->sub_sections = PageSections::where('status', 'active')
                                               ->where('parent_id', $page_section->id)
                                               ->get();

    return $page_section;
}



       public function pagesubsection_data(Request $request) {
        
            $encryptpageid = $request->page_id;
        //    dd(Crypt::decrypt($encryptpageid));
             $encryted_section_id = $request->section_id;
            $id =  Crypt::decrypt($request->section_id);
    
   $pages = PageSections::where(['page_id' => $id, 'parent_id' => Crypt::decrypt($encryptpageid)])->orderBy('position_order')->get();

         
          $model = Crypt::encrypt('Pages');
                return DataTables::of($pages)
            ->addIndexColumn()
            ->addColumn('section_title', function($pages){
                return $pages->section_title;
            })
            ->addColumn('section_headline', function($pages){
                return $pages->section_headline;
            })
            ->addColumn('position_order', function($pages){
                return $pages->position_order? $pages->position_order : ''; 
            })
            ->addColumn('section_image', function ($sections) {
                if (empty($sections->section_image)) {
                    return '-'; // or empty string
                }

                $imgUrl = asset($sections->section_image);
                $alt    = $sections->section_headline ?? 'Image';

                return '<a href="javascript:void(0)" class="hstack gap-3">
                            <div class="avatar-image avatar-md">
                                <img src="' . e($imgUrl) . '"
                                    alt="' . e($alt) . '"
                                    class="img-fluid">
                            </div>
                        </a>';
            })
            
            ->addColumn('is_active', function($pages){
                return $pages->status == 'active' ? 'Active' : 'In active';
            })
            ->addColumn('action', function ($pages) use ($id, $model, $encryptpageid, $encryted_section_id) {
            $encryptedId = Crypt::encrypt($pages->id); 
            
            $pageid = $id;

            $encryptsubsectionId = Crypt::encrypt($pages->id);
                $model = Crypt::encrypt('PageSections');
                return '<div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a  href="' . route('admin.edit.page.subsection', [
                           'page'=> $encryted_section_id,'section' => $encryptpageid, 'subsection' => $encryptsubsectionId]) . '" class="dropdown-item">Modify</a>
                                 <button class="dropdown-item delete"
                                    onclick="delete_item(\'' . $model . '\', \'' . $encryptedId . '\');"
                                    data-id="' . $pages->id . '">
                                Delete 
                            </button>
                            </div>
                        </div>';
            })
            ->rawColumns(['action', 'section_image', 'more_images'])
            ->make(true);
    
    }


}
