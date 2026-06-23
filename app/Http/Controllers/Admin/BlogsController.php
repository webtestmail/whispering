<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Blogs;
use App\Models\Admin\BlogSections;
use App\Models\Admin\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogsController extends Controller
{
    public function checkBlogLink($link, $encrypted_id = "")
    {
        $link = str_replace(['/', ' '], '-', $link);
        $link = preg_replace('/[^a-z0-9-]+/', '-', $link);
        $link = trim($link, '-');
        $link = preg_replace('/-+/', '-', $link);
        $original_link = $link;

        $id = (isset($encrypted_id) && !empty($encrypted_id)) ? Crypt::decrypt($encrypted_id) : 0;
        $suffix = 1;
        do {
            $count = $id != 0 ? Blogs::where('blog_url', $link)->where('id', '!=', $id)->count() : Blogs::where('blog_url', $link)->count();

            if ($count > 0) {
                $link = $original_link . '-' . $suffix;
                $suffix++;
            } else {
                break;
            }
        } while (true);

        return $link;
    }

    public function manageBlogs()
    {
        // $blogs = Blogs::select(
        //     'blogs.id',
        //     'blogs.position_order',
        //     'blogs.blog_headline',
        //     'blogs.blog_url',
        //     'blogs.written_by',
        //     'blogs.writer_image',
        //     'blogs.blog_image',
        //     'blogs.blog_on_banner',
        //     'blogs.status',
        //     'categories.category_headline',
        //     'categories.category_url'
        // )->join('categories', 'categories.id', '=', 'blogs.category_id')->where([
        //     'categories.reference_type' => 'blog',
        //     'categories.status' => 'active'
        // ])->orderBy('blogs.position_order')->get();
        $blogs = Blogs::orderByDesc('is_featured')->orderBy('position_order')->get();
        foreach ($blogs as $blog) {
            $blog->encrypted_id = Crypt::encrypt($blog->id);
        }

        $main_page = 'blogs_management';
        $currentPage = "manage_blogs";
        $model = Crypt::encrypt('Blogs');
        return view('admin.manage_blogs', ['blogsData' => $blogs, 'model' => $model, 'main_page' => $main_page, 'currentPage' => $currentPage]);
    }

    public function addBlog(Request $request)
    {
        
        if ($request->isMethod('post')) {
            $request->validate([
                // 'blog_category' => 'required',
                'blog_headline' => 'required|string',
                'blog_url' => 'required|string',
                'written_by' => 'string',
            ], [
                // 'blog_category.required' => 'Please provide a category for the blog.',
                'blog_headline.required' => 'Please provide a headline for the blog.',
                'blog_headline.string' => 'Blog headline must be a string.',
                'blog_url.required' => 'Please provide URL for the blog.',
                'blog_url.string' => 'URL must be a string.',
                'written_by.string' => 'The author name must be a string.',
            ]);

            $order = Blogs::max('position_order');
            $position_order = ($order !== null) ? $order + 1 : 1;

            $tags = $request->blog_tags;
            $tags = preg_replace('/\s+/', ' ', $tags);  // Convert multiple spaces to single space
            $tags = preg_replace('/[^A-Za-z0-9 ]+| (?=[^A-Za-z0-9])|(?<=[^A-Za-z0-9]) /', ',', $tags);  // Replace any sequence of special characters or spaces between tags with one comma
            $tags = preg_replace('/,+/', ',', $tags);   // Replace 2+ commas with single comma
            $tags = trim($tags, ',');   // Trim commas
            $tagsArray = array_unique(array_filter(array_map('trim', explode(',', $tags))));    // OPTIONAL remove duplicate tags
            $tags = implode(',', $tagsArray);



            if (!empty($request->blog_url)) {
                $link = strtolower($request->blog_url);
            } else {
                $link = strtolower($request->blog_headline);
            }
            $blog_url = $this->checkBlogLink($link);

            $blog = [
                // 'category_id' => Crypt::decrypt($request->blog_category) ?? 0,
                'category_id' => 0,
                'position_order' => $position_order,
                'blog_tags' => $tags,
                // 'show_in_categories' => '',
                'blog_headline' => $request->blog_headline,
                'blog_url' => $blog_url,
                'short_description' => htmlspecialchars($request->short_description, ENT_QUOTES),
                // 'description' => htmlspecialchars($request->description, ENT_QUOTES),
                'written_by' => $request->written_by,
                'writer_designation' => $request->writer_designation,
                'writer_description' => htmlspecialchars($request->writer_description, ENT_QUOTES),
                'writer_instagram' => $request->writer_instagram,
                'writer_linkedin' => $request->writer_linkedin,
                'writer_x' => $request->writer_x,
                'writer_personal' => $request->writer_personal,
                // 'writer_facebook' => $request->writer_facebook,
                // 'writer_threads' => $request->writer_threads,
                'post_date' => date("Y-m-d"),
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => htmlspecialchars($request->meta_description, ENT_QUOTES),
            ];
            

           

            if (!empty($request->file('breadcrumb_image'))) {
                $path = 'images/blogs/';
                $filePath = $this->storeImage($request->file('breadcrumb_image'), $path);
                $blog['breadcrumb_image'] = $filePath;
            }
            if (!empty($request->file('blog_image'))) {
                $path = 'images/blogs/';
                $filePath = $this->storeImage($request->file('blog_image'), $path);
                $blog['blog_image'] = $filePath;
            }
            if (!empty($request->file('writer_image'))) {
                $path = 'images/blogs/writers/';
                $filePath = $this->storeImage($request->file('writer_image'), $path);
                $blog['writer_image'] = $filePath;
            }

            $blog_created = Blogs::create($blog);
                       
            if ($blog_created) {
                if ((isset($request->section_titles) && count($request->section_titles) > 0)) {
                    DB::beginTransaction();
                    try {
                        $total_sections = count($request->section_titles);
                        for ($i = 0; $i < $total_sections; $i++) {
                            $blog_section = array(
                                'blog_id' => $blog_created->id,
                                'section_title' => $request->section_titles[$i],
                                'section_headline' => $request->section_headlines[$i],
                                'description' => htmlspecialchars($request->descriptions[$i]),
                            );

                            // if ($request->hasFile("section_images.$i")) {
                            //     $path = 'images/blogs/sections/';
                            //     $filePath = $this->storeImage($request->file("section_images.$i"), $path);
                            //     $blog_section['section_image'] = $filePath;
                            // }

                            $blog_section_created = BlogSections::create($blog_section);
                            if ($blog_section_created) {
                                $blog_section_created->update([
                                    'default_section_name' => 'section_' . $blog_section_created->id
                                ]);
                            }
                        }
                        DB::commit();
                        $request->session()->flash('success', 'Blog & Sections are inserted Successfully!');
                        return redirect()->route('admin.manage_blogs');
                    } catch (\Exception $e) {
                        DB::rollBack();
                        $request->session()->flash('error', 'Section Insertion Error: ' . $e->getMessage());
                        return redirect()->back();
                    }
                }
                 else {
                       $request->session()->flash('success', 'Blog & Sections are inserted Successfully!');
                      return redirect()->route('admin.manage_blogs');
                 }
            } else {
                $request->session()->flash('error', 'Blog Insertion Error!');
                return redirect()->back();
            }
        } else {
            // $categories = Categories::select('id', 'category_headline')->where(['reference_type' => 'blog', 'status' => 'active'])->orderBy('position_order')->get();
            // foreach ($categories as $category) {
            //     $category->encrypted_id = Crypt::encrypt($category->id);
            // }

            $main_page = 'blogs_management';
            $currentPage = "manage_blogs";
            return view('admin.blog-ops', ['main_page' => $main_page, 'currentPage' => $currentPage]);  // "allCategories" => $categories, 
        }
    }

    public function editBlog(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                // 'blog_category' => 'required',
                'blog_headline' => 'required|string',
                'blog_url' => 'required|string',
                'written_by' => 'string',
            ], [
                // 'blog_category.required' => 'Please provide a category for the blog.',
                'blog_headline.required' => 'Please provide a headline for the blog.',
                'blog_headline.string' => 'Blog headline must be a string.',
                'blog_url.required' => 'Please provide URL for the blog.',
                'blog_url.string' => 'URL must be a string.',
                'written_by.string' => 'The author name must be a string.',
            ]);

            $tags = $request->blog_tags;
            $tags = preg_replace('/\s+/', ' ', $tags);  // Convert multiple spaces to single space
            $tags = preg_replace('/[^A-Za-z0-9 ]+| (?=[^A-Za-z0-9])|(?<=[^A-Za-z0-9]) /', ',', $tags);  // Replace any sequence of special characters or spaces between tags with one comma
            $tags = preg_replace('/,+/', ',', $tags);   // Replace 2+ commas with single comma
            $tags = trim($tags, ',');   // Trim commas
            $tagsArray = array_unique(array_filter(array_map('trim', explode(',', $tags))));    // OPTIONAL remove duplicate tags
            $tags = implode(',', $tagsArray);

            if (!empty($request->blog_url)) {
                $link = strtolower($request->blog_url);
            } else {
                $link = strtolower($request->blog_headline);
            }
            $blog_url = $this->checkBlogLink($link, $request->blog);

            $blog_id = Crypt::decrypt($request->blog);
            $blog = Blogs::findOrFail($blog_id);
            // $blog->category_id = Crypt::decrypt($request->blog_category) ?? 0;
            $blog->category_id = 0;
            $blog->blog_tags = $tags;
            // $blog->show_in_categories = '';
            $blog->blog_headline = $request->blog_headline;
            $blog->blog_url = $blog_url;
            $blog->short_description = htmlspecialchars($request->short_description, ENT_QUOTES);
            // $blog->description = htmlspecialchars($request->description, ENT_QUOTES);
            $blog->written_by = $request->written_by;
            $blog->writer_instagram = $request->writer_instagram;
            $blog->writer_linkedin = $request->writer_linkedin;
            $blog->writer_x = $request->writer_x;
            // $blog->writer_facebook = $request->writer_facebook;
            // $blog->writer_threads = $request->writer_threads;
            $blog->meta_title = $request->meta_title;
            $blog->meta_keyword = $request->meta_keyword;
            $blog->meta_description = htmlspecialchars($request->meta_description, ENT_QUOTES);

            if (!empty($request->file('breadcrumb_image'))) {
                $path = 'images/blogs/';
                $filePath = $this->storeImage($request->file("breadcrumb_image"), $path, $blog->breadcrumb_image);
                $blog->breadcrumb_image = $filePath;
            }
            if (!empty($request->file('blog_image'))) {
                $path = 'images/blogs/';
                $filePath = $this->storeImage($request->file("blog_image"), $path, $blog->blog_image);
                $blog->blog_image = $filePath;
            }
            if (!empty($request->file('writer_image'))) {
                $path = 'images/blogs/writers/';
                $filePath = $this->storeImage($request->file("writer_image"), $path, $blog->section_image);
                $blog->writer_image = $filePath;
            }

            if ($blog->save()) {
                DB::beginTransaction();
                try {
                    if (isset($request->section) && count($request->section) > 0) {
                        foreach ($request->section as $i => $enc_blog_section) {
                            $blog_section_id = !empty($enc_blog_section) ? Crypt::decrypt($enc_blog_section) : 0;
                            if ($blog_section_id == 0) {
                                $blog_section = array(
                                    'blog_id' => $blog_id,
                                    'section_title' => $request->section_titles[$i],
                                    'section_headline' => $request->section_headlines[$i],
                                    'description' => htmlspecialchars($request->descriptions[$i]),
                                );

                                // if ($request->hasFile("section_images.$i")) {
                                //     $path = 'images/blogs/sections/';
                                //     $filePath = $this->storeImage($request->file("section_images.$i"), $path);
                                //     $blog_section['section_image'] = $filePath;
                                // }

                                $blog_section_created = BlogSections::create($blog_section);
                                if ($blog_section_created) {
                                    $blog_section_created->update([
                                        'default_section_name' => 'section_' . $blog_section_created->id
                                    ]);
                                }
                            } else {
                                $blog_section = BlogSections::findOrFail($blog_section_id);
                                $blog_section->section_title = $request->section_titles[$i];
                                $blog_section->section_headline = $request->section_headlines[$i];
                                $blog_section->description = htmlspecialchars($request->descriptions[$i]);

                                // if ($request->hasFile("section_images.$i")) {
                                //     $path = 'images/blogs/sections/';
                                //     $filePath = $this->storeImage($request->file("section_images.$i"), $path, $blog_section->section_image);
                                //     $blog_section->section_image = $filePath;
                                // }

                                $blog_section->save();
                            }
                        }
                    }
                    DB::commit();
                    $request->session()->flash('success', 'Blog & Sections are updated Successfully!');
                    return redirect()->route('admin.manage_blogs');
                } catch (\Exception $e) {
                    DB::rollBack();
                    $request->session()->flash('error', 'Section Updation Error: ' . $e->getMessage());
                    return redirect()->back();
                }
            } else {
                $request->session()->flash('error', 'Blog Updation Error!');
                return redirect()->back();
            }
        } else {
            $id = Crypt::decrypt($request->blog);
            $blog = Blogs::where('id', $id)->firstOrFail();
            $blog->encrypted_id = $request->blog;
            // $categories = Categories::select('id', 'category_headline')->where(['reference_type' => 'blog', 'status' => 'active'])->orderBy('position_order')->get();
            // foreach ($categories as $category) {
            //     $category->encrypted_id = Crypt::encrypt($category->id);
            // }

            $main_page = 'blogs_management';
            $currentPage = "manage_blogs";
            return view('admin.blog-ops', ["blog" => $blog, 'main_page' => $main_page, 'currentPage' => $currentPage]); // "allCategories" => $categories, 
        }
    }

    public function changeFeaturedBlog(Request $request)
    {
        $id = Crypt::decrypt($request->encrypted_id);
        Blogs::where('is_featured', 1)->update(['is_featured' => 0]);
        $blog = Blogs::find($id);
        if ($blog) {
            $blog->is_featured = 1;
            if ($blog->save()) {
                return response()->json(['status' => 'done', 'message' => "Featured Blog is done."]);
            } else {
                return response()->json(['status' => 'error', 'message' => "Can't operate the Featured Blog operation!"]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => "Can't find the data!"]);
        }
    }

    public function getBlogSection(Request $request)
    {
        $blog_id = Crypt::decrypt($request->blog);
        $blog_sections = BlogSections::where('blog_id', $blog_id)->get();

        $sections_data = [];
        foreach ($blog_sections as $section) {
            $section_data = [
                "section_id" => Crypt::encrypt($section->id),
                "section_title" => $section->section_title,
                "section_headline" => $section->section_headline,
                "description" => htmlspecialchars_decode($section->description),
                // "section_images" => $section->section_image,
            ];
            array_push($sections_data, $section_data);
        }
        return response()->json($sections_data);
    }

    public function deleteBlogSection(Request $request)
    {
        $blog_section_id = Crypt::decrypt($request->section);
        $blog_section = BlogSections::find($blog_section_id);
        if ($blog_section) {
            // $this->removeImage($blog_section->section_image);
            $blog_section->delete();
        } else {
            return response()->json(['status' => 'error', 'title' => "Data Not Found!", 'message' => "Can't find the data!"]);
        }
    }

    // public function findBlogReadTime($id)
    // {
    //     $blog = Blogs::select(
    //         'blogs.blog_headline',
    //         'blogs.short_description',
    //         'blogs.description',
    //         'categories.category_headline'
    //     )->join('categories', 'categories.id', '=', 'blogs.category_id')->where('blogs.id', $id)->first();
    //     if (!$blog) {
    //         return 0;
    //     }

    //     $content = $blog->category_headline . " " . $blog->blog_headline . " " . strip_tags(htmlspecialchars_decode($blog->short_description)) . " " . strip_tags(htmlspecialchars_decode($blog->description));
    //     $blog_sections = BlogSections::select('section_title', 'section_headline', 'description')->where('id', $id)->get();
    //     foreach ($blog_sections as $section) {
    //         $content .= " " . $section->section_title . " " . $section->section_headline . " " . strip_tags(htmlspecialchars_decode($section->description));
    //     }

    //     // Count total words
    //     $wordCount = str_word_count($content);

    //     // Average reading speed: 50 words per minute
    //     $readingTime = ceil($wordCount / 50);

    //     return $readingTime;
    // }

    public function featuredBlog()
    {
        return Blogs::where(['is_featured' => 1, 'status' => 'active'])->first();
    }

    public function getBlogs()
    {
        return Blogs::where(['is_featured'=> 0,'status'=>'active'])->orderByDesc('id')->limit(6)->get();
    }

    public function getLatestBlogs($limit = null)
    {
        // return Blogs::select('id', 'blog_headline', 'blog_url', 'short_description', 'post_date', 'written_by', 'writer_image', 'blog_image')->where('status', 'active')->orderByDesc('id')->get();
        $query = Blogs::select(
            'blogs.id',
            'blogs.blog_headline',
            'blogs.blog_url',
            'blogs.short_description',
            'blogs.post_date',
            'blogs.written_by',
            'blogs.writer_image',
            'blogs.blog_image',
            'categories.category_url'
        )->join('categories', 'categories.id', '=', 'blogs.category_id')->where('blogs.status', 'active')->orderByDesc('blogs.id');

        if (!empty($limit)) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function submitSearchBlogsData(Request $request)
    {
        $request->validate([
            'blog_search' => 'required|string',
        ], [
            'blog_search.required' => 'Please provide a search content for the Blogs.',
            'blog_search.string' => 'Blog search content must be a string.',
        ]);

        $searchTerm = $request->blog_search;
        $all_blogs = Blogs::select(
            'blogs.id',
            'blogs.blog_headline',
            'blogs.blog_url',
            // 'blogs.short_description',
            // 'blogs.written_by',
            // 'blogs.writer_image',
            // 'blogs.blog_image',
            // 'categories.category_name',
            'categories.category_url'
        )->join('categories', 'categories.id', '=', 'blogs.category_id')
            ->where('blogs.status', 'active')
            ->where(function ($query) use ($searchTerm) {
                $query->where('blogs.blog_headline', 'like', "%$searchTerm%")
                    ->orWhere('blogs.blog_url', 'like', "%$searchTerm%")
                    ->orWhere('categories.category_headline', 'like', "%$searchTerm%")
                    ->orWhere('categories.category_url', 'like', "%$searchTerm%");
            })
            ->orderByDesc('blogs.created_at')
            ->get();

        $rendered_html = '';
        foreach ($all_blogs as $blog) {
            $rendered_html .= '
                <a href="' . route('single.blog', ["category_url" => $blog->category_url, "blog_url" => $blog->blog_url]) . '">' . $blog->blog_headline . '</a>
            ';
        }

        return response()->json([
            'status' => 'success',
            'rendered_html' => $rendered_html,
        ]);
    }
}
