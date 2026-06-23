<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blogs;
use App\Models\Admin\ServiceFaqs;
use App\Models\Admin\Services;
use App\Models\Admin\ServiceSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    function getServicesPage()
    {
        $all_services = Services::select('id', 'position_order', 'service_name')->orderBy('position_order')->get();
        foreach ($all_services as $service) {
            $service->encrypted_id = Crypt::encrypt($service->id);
        }

        $currentPage = "manage_services";
        return view('admin.service_sequences_ops', ["servicesData" => $all_services, 'currentPage' => $currentPage]);
    }

    function saveServicesSequence(Request $request)
    {
        if (isset($request->service_ids) && count($request->service_ids) > 0) {
            if (isset($request->sequences) && count($request->sequences) > 0) {
                $sequences = $request->sequences;
            } else {
                $sequences = ["1"];
            }
        }
        $executions = 0;

        if (isset($sequences) && count($sequences) > 0) {
            $encrypted_ids = $request->service_ids;
            foreach ($encrypted_ids as $key => $encrypted_id) {
                $id = Crypt::decrypt($encrypted_id);
                $sequence = $sequences[$key];

                $page = Services::findOrFail($id);
                $page->position_order = $sequence;
                $page->save();
                $executions += 1;
            }
            if ($executions == 0) {
                $request->session()->flash('error', 'Can\'t update the data!');
                return redirect()->route('admin.get.services.page');
            } else {
                $request->session()->flash('success', 'Sequence is updated Successfully!');
                return redirect()->route('admin.manage_services');
            }
        } else {
            $request->session()->flash('error', 'Data is not there!');
            return redirect()->route('admin.get.services.page');
        }
    }

    function checkServiceLink($link, $encrypted_id = "")
    {
        $link = str_replace(['/', ' '], '-', $link);
        $link = preg_replace('/[^a-z0-9-]+/', '-', $link);
        $link = trim($link, '-');
        $link = preg_replace('/-+/', '-', $link);
        $original_link = $link;

        $id = (isset($encrypted_id) && !empty($encrypted_id)) ? Crypt::decrypt($encrypted_id) : 0;
        $suffix = 1;
        do {
            $count = $id != 0 ? Services::where('service_url', $link)->where('id', '!=', $id)->count() : Services::where('service_url', $link)->count();

            if ($count > 0) {
                $link = $original_link . '-' . $suffix;
                $suffix++;
            } else {
                break;
            }
        } while (true);

        return $link;
    }

    function manageServices()
    {
        $services = Services::select('id', 'position_order', 'service_name', 'service_url', 'breadcrumb_image', 'service_image', 'visibility', 'status')->orderBy('position_order')->get();
        foreach ($services as $service) {
            $service->encrypted_id = Crypt::encrypt($service->id);
        }
        $model = Crypt::encrypt('Services');
        $currentPage = "manage_services";
        return view('admin.manage_services', ['servicesData' => $services, 'model' => $model, "currentPage" => $currentPage]);
    }

    function addService(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'service_title' => 'required|string',
                'service_name' => 'required|string',
                'service_url' => 'required|string',
            ], [
                'service_title.required' => 'Please provide a title for the service.',
                'service_title.string' => 'Service Title must be a string.',
                'service_name.required' => 'Please provide a name for the service.',
                'service_name.string' => 'Service Name must be a string.',
                'service_url.required' => 'Please provide URL for the service.',
                'service_url.string' => 'URL must be a string.',
            ]);

            $order = Services::max('position_order');
            $position_order = ($order !== null) ? $order + 1 : 1;

            if (!empty($request->service_url)) {
                $link = strtolower($request->service_url);
            } else {
                $link = strtolower($request->service_name);
            }
            $service_url = $this->checkServiceLink($link);

            $service = [
                'position_order' => $position_order,
                'service_title' => $request->service_title,
                'service_name' => $request->service_name,
                'service_url' => $service_url,
                'short_description' => htmlspecialchars($request->short_description, ENT_QUOTES),
                'service_icon' => $request->service_icon,
                'service_highlights' => htmlspecialchars($request->service_highlights, ENT_QUOTES),
                'description' => htmlspecialchars($request->description, ENT_QUOTES),
                'breadcrumb_headline' => $request->breadcrumb_headline,
                'breadcrumb_description' => htmlspecialchars($request->breadcrumb_description, ENT_QUOTES),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => htmlspecialchars($request->meta_description, ENT_QUOTES),
            ];

            if (!empty($request->file('breadcrumb_image'))) {
                $path = 'images/services/';
                $filePath = $this->storeImage($request->file('breadcrumb_image'), $path);
                $service['breadcrumb_image'] = $filePath;
            }
            if (!empty($request->file('service_image'))) {
                $path = 'images/services/';
                $filePath = $this->storeImage($request->file('service_image'), $path);
                $service['service_image'] = $filePath;
            }

            $new_service = Services::create($service);
            if ($new_service) {
                $lastServiceId = $new_service->id;
                $content_res = false;
                try {
                    DB::beginTransaction(); // Start database transaction

                    if (empty($request->content_headlines)) {
                        DB::rollBack();
                        session()->flash('success', 'Service is inserted Successfully!');
                        return redirect()->route('admin.manage_services');
                    }

                    // Insert contents
                    if (!isset($request->content_headlines)) {
                        $content_res = true;
                    }
                    if (!empty($request->content_headlines) && is_array($request->content_headlines)) {
                        $contents = [];
                        $content_order = ServiceSections::where('service_id', $lastServiceId)->max('position_order');
                        $content_position_order = ($content_order !== null) ? $content_order + 1 : 1;
                        $total_contents = count($request->content_headlines);

                        for ($i = 0; $i < $total_contents; $i++) {
                            $content_data = [
                                'position_order' => $content_position_order,
                                'service_id' => $lastServiceId,
                                'section_icon' => $request->content_icons[$i] ?? null,
                                'section_headline' => $request->content_headlines[$i] ?? null,
                                'description' => isset($request->descriptions[$i]) ? htmlspecialchars($request->descriptions[$i], ENT_QUOTES) : null,
                            ];

                            $contents[] = $content_data; // Add to batch insert array
                            $content_position_order++;
                        }

                        // Batch insert contents
                        ServiceSections::insert($contents);
                        $content_res = true;
                    }

                    DB::commit(); // Commit transaction if everything is successful
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback transaction on error
                    // \Log::error('Error inserting subtreatment data: ' . $e->getMessage());
                    $content_res = false;
                }

                if ($content_res) {
                    session()->flash('success', 'Service is inserted Successfully!');
                    return redirect()->route('admin.manage_services');
                } else {
                    session()->flash('error', 'Insertion Error in Contents data!');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Insertion Error!');
                return redirect()->back();
            }
        } else {
            $currentPage = "manage_services";
            return view('admin.service-ops', ['currentPage' => $currentPage]);
        }
    }

    function editService(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'service_title' => 'required|string',
                'service_name' => 'required|string',
                'service_url' => 'required|string',
            ], [
                'service_title.required' => 'Please provide a title for the service.',
                'service_title.string' => 'Service Title must be a string.',
                'service_name.required' => 'Please provide a name for the service.',
                'service_name.string' => 'Service Name must be a string.',
                'service_url.required' => 'Please provide URL for the service.',
                'service_url.string' => 'URL must be a string.',
            ]);

            if (!empty($request->service_url)) {
                $link = strtolower($request->service_url);
            } else {
                $link = strtolower($request->service_name);
            }
            $service_url = $this->checkServiceLink($link, $request->service);

            $id = Crypt::decrypt($request->service);
            $service = Services::findOrFail($id);
            $service->service_title = $request->service_title;
            $service->service_name = $request->service_name;
            $service->service_url = $service_url;
            $service->short_description = htmlspecialchars($request->short_description, ENT_QUOTES);
            $service->service_icon = $request->service_icon;
            $service->service_highlights = htmlspecialchars($request->service_highlights, ENT_QUOTES);
            $service->description = htmlspecialchars($request->description, ENT_QUOTES);
            $service->breadcrumb_headline = $request->breadcrumb_headline;
            $service->breadcrumb_description = htmlspecialchars($request->breadcrumb_description, ENT_QUOTES);
            $service->meta_title = $request->meta_title;
            $service->meta_keyword = $request->meta_keyword;
            $service->meta_description = htmlspecialchars($request->meta_description, ENT_QUOTES);

            if (!empty($request->file('breadcrumb_image'))) {
                $path = 'images/services/';
                $filePath = $this->storeImage($request->file("breadcrumb_image"), $path, $service->breadcrumb_image);
                $service->breadcrumb_image = $filePath;
            }
            if (!empty($request->file('service_image'))) {
                $path = 'images/services/';
                $filePath = $this->storeImage($request->file("service_image"), $path, $service->service_image);
                $service->service_image = $filePath;
            }

            if ($service->save()) {
                $content_res = false;

                try {
                    DB::beginTransaction(); // Start database transaction

                    if (empty($request->contents)) {
                        DB::rollBack();
                        session()->flash('success', 'Service is updated successfully!');
                        return redirect()->route('admin.manage_services');
                    }

                    // Handle Contents
                    if (!isset($request->contents)) {
                        $content_res = true;
                    } elseif (!empty($request->contents) && is_array($request->contents)) {
                        $contents = [];
                        $content_order = ServiceSections::where('service_id', $id)->max('position_order');
                        $content_position_order = ($content_order !== null) ? $content_order + 1 : 1;
                        foreach ($request->contents as $i => $content) {
                            if (!empty($content)) {
                                // Update existing content
                                $content_id = Crypt::decrypt($content);
                                $service_content = ServiceSections::find($content_id);
                                if ($service_content) {
                                    $service_content->section_icon = $request->content_icons[$i] ?? null;
                                    $service_content->section_headline = $request->content_headlines[$i] ?? null;
                                    $service_content->description = isset($request->descriptions[$i]) ? htmlspecialchars($request->descriptions[$i], ENT_QUOTES) : null;
                                    $service_content->save();
                                }
                            } else {
                                // Prepare new content data for batch insert
                                $contents[] = [
                                    'position_order' => $content_position_order,
                                    'service_id' => $id,
                                    'section_icon' => $request->content_icons[$i] ?? null,
                                    'section_headline' => $request->content_headlines[$i] ?? null,
                                    'description' => isset($request->descriptions[$i]) ? htmlspecialchars($request->descriptions[$i], ENT_QUOTES) : null,
                                ];
                                $content_position_order++;
                            }
                        }

                        // Batch insert new contents
                        if (!empty($contents)) {
                            ServiceSections::insert($contents);
                        }

                        $content_res = true;
                    }

                    DB::commit(); // Commit transaction if everything is successful
                } catch (\Exception $e) {
                    DB::rollBack(); // Rollback transaction on error
                    // \Log::error('Error updating subtreatment data: ' . $e->getMessage());
                    $content_res = false;
                }

                if ($content_res) {
                    session()->flash('success', 'Service is updated successfully!');
                    return redirect()->route('admin.manage_services');
                } else {
                    session()->flash('error', 'Error updating Contents data!');
                    return redirect()->back();
                }
            } else {
                session()->flash('error', 'Updation Error!');
                return redirect()->back();
            }
        } else {
            $id = Crypt::decrypt($request->service);
            $service = Services::find($id);
            $service->encrypted_id = $request->service;

            $currentPage = "manage_services";
            return view('admin.service-ops', ["service" => $service, 'currentPage' => $currentPage]);
        }
    }

    function getServiceContents(Request $request)
    {
        $service_id = Crypt::decrypt($request->service);
        $allSections = ServiceSections::select('id', 'section_headline', 'description', 'section_icon')->where('service_id', $service_id)->get();

        $all_service_sections = $allSections->map(function ($service_section) {
            return [
                'content_id' => Crypt::encrypt($service_section->id),
                'content_icon' => $service_section->section_icon,
                'content_headline' => $service_section->section_headline,
                'description' => htmlspecialchars_decode($service_section->description),
            ];
        });

        return response()->json($all_service_sections);
    }

    function deleteServiceContent(Request $request)
    {
        $content_id = Crypt::decrypt($request->content);
        $service_content = ServiceSections::find($content_id);
        if ($service_content->delete()) {
            return 1;
        } else {
            return 0;
        }
    }

    // function getAllServiceBlogs($service_blog_ids, $limit = null)
    // {
    //     // return Blogs::whereIn("id", $service_blog_ids)->where('status', 'active')->orderBy('position_order')->get();
    //     $query = Blogs::select(
    //         'blogs.id',
    //         'blogs.blog_headline',
    //         'blogs.blog_url',
    //         'blogs.short_description',
    //         'blogs.written_by',
    //         'blogs.writer_image',
    //         'blogs.blog_image',
    //         'categories.category_url'
    //     )->join('categories', 'categories.id', '=', 'blogs.category_id')->whereIn("blogs.id", $service_blog_ids)->where('blogs.status', 'active')->orderByDesc('blogs.position_order');

    //     if (!empty($limit)) {
    //         $query->limit($limit);
    //     }

    //     return $query->get();
    // }

    // function getAllServiceFaqs($service_id)
    // {
    //     return ServiceFaqs::where(["service_id" => $service_id, 'status' => 'active'])->orderBy('position_order')->get();
    // }

    // function getAllServices($currentPage = '')
    // {
    //     if ($currentPage == 'home') {
    //         return Services::select('id', 'service_name', 'service_url', 'service_image', 'description')->where(['status' => 'active'])->orderBy('position_order')->limit(6)->get();
    //     }
    //     return Services::select('id', 'service_name', 'service_url', 'service_image', 'description')->where(['status' => 'active'])->orderBy('position_order')->get();
    // }

    // function headerFooterServices()
    // {
    //     return Services::select('id', 'header_footer_name', 'service_url', 'visibility')->whereIn('visibility', ["header", "footer", "both"])->where(['status' => 'active'])->orderBy('position_order')->get();
    // }
}
