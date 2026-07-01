<?php

use App\Http\Controllers\Admin\auth\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AccommodationsController;
use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\ExperiencesController;
use App\Http\Controllers\Admin\BannersController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DeleteController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\GalleriesController;
use App\Http\Controllers\Admin\GalleryCategoriesController;
use App\Http\Controllers\Admin\LegalController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\TestimonialsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisibilityController;
use App\Http\Middleware\AdminChangeStatusMiddleware;
use App\Http\Middleware\AdminChangeVisibilityMiddleware;
use App\Http\Middleware\AdminDeleteMiddleware;
use App\Http\Middleware\is_admin;
use Illuminate\Support\Facades\Route;

Route::get('/admin-panel', [AdminAuthController::class, 'admin_login_view'])->name('admin.panel');
Route::post('admin_auth', [AdminAuthController::class, 'admin_auth'])->name('admin_auth');

Route::match(['get', 'post'], '/change_visibility', [VisibilityController::class, 'index'])
    ->name('change.visibility')
    ->middleware(AdminChangeVisibilityMiddleware::class);
Route::match(['get', 'post'], '/change_status', [StatusController::class, 'index'])
    ->name('change.status')
    ->middleware(AdminChangeStatusMiddleware::class);
Route::match(['get', 'post'], '/delete_item', [DeleteController::class, 'index'])
    ->name('delete.item')
    ->middleware(AdminDeleteMiddleware::class);
Route::match(['get', 'post'], '/change_header_footer_visibility', [VisibilityController::class, 'headerFooterIndex'])
    ->name('change.header.footer.visibility')
    ->middleware(AdminChangeVisibilityMiddleware::class);

Route::prefix('/admin')->name('admin.')->middleware(['auth:admin', is_admin::class])->group(function () {
    Route::get('/my-dashboard', [AdminAuthController::class, 'my_dashboard'])->name('my-dashboard');
    Route::match(['get', 'post'], '/edit_profile', [AdminAuthController::class, 'editProfile'])->name('edit.profile');
    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/get_pages_page', [PagesController::class, 'getPagesPage'])->name('get.pages.page');
    Route::get('/pages-data', [PagesController::class, 'pages_data'])->name('pages.data');
    Route::post('/pages_sequence', [PagesController::class, 'savePagesSequence'])->name('save.pages.sequence');
    Route::get('/manage_pages', [PagesController::class, 'managePages'])->name('manage_pages');
    Route::match(['get', 'post'], '/add_page', [PagesController::class, 'addPage'])->name('add.page');
    Route::match(['get', 'post'], '/edit_page/{page}', [PagesController::class, 'editPage'])->name('edit.page');

    Route::get('/get_sections_page/{page}/{section}', [PagesController::class, 'getSectionsPage'])->name('get.sections.page');
    Route::get('/pagesection-data', [PagesController::class, 'pagesection_data'])->name('pagesection.data');
    Route::post('/sections_sequence', [PagesController::class, 'saveSectionsSequence'])->name('save.sections.sequence');
    Route::match(['get', 'post'], '/add_page_section/{page}', [PagesController::class, 'addPageSection'])->name('add.page.section');
    Route::match(['get', 'post'], '/edit_page_section/{page}/{section}', [PagesController::class, 'editPageSection'])->name('edit.page.section');
    Route::get('/pagesubsection-data', [PagesController::class, 'pagesubsection_data'])->name('pagesubsection.data');
    Route::match(['get', 'post'], '/add_page_subsection/{page}/{section}', [PagesController::class, 'addPageSubSection'])->name('add.page.subsection');
    Route::match(['get', 'post'], '/edit_page_subsection/{page}/{section}/{subsection}', [PagesController::class, 'editPageSubSection'])->name('edit.page.subsection');

    Route::get('/manage_banners', [BannersController::class, 'manageBanners'])->name('manage_banners');
    Route::match(['get', 'post'], '/add_banner', [BannersController::class, 'addBanner'])->name('add.banner');
    Route::match(['get', 'post'], '/edit_banner/{banner}', [BannersController::class, 'editBanner'])->name('edit.banner');

    Route::get('/manage_users', [UserController::class, 'manageUsers'])->name('manage_users');
    Route::get('/users-data', [UserController::class, 'user_data'])->name('users.data');
    Route::match(['get', 'post'], '/user-edit/{id}', [UserController::class, 'user_edit'])->name('user.edit');
    Route::delete('/delete-user', [UserController::class, 'deleteUser'])->name('user.delete');

    Route::get('/get_services_page', [ServicesController::class, 'getServicesPage'])->name('get.services.page');
    Route::post('/services_sequence', [ServicesController::class, 'saveServicesSequence'])->name('save.services.sequence');
    Route::get('/check_service_link/{service_url}/{id?}', [ServicesController::class, 'checkServiceLink'])->name('check.service.link');
    Route::get('/manage_services', [ServicesController::class, 'manageServices'])->name('manage_services');
    Route::match(['get', 'post'], '/add_service', [ServicesController::class, 'addService'])->name('add.service');
    Route::match(['get', 'post'], '/edit_service/{service}', [ServicesController::class, 'editService'])->name('edit.service');
    Route::get('/get_service_contents/{service}', [ServicesController::class, 'getServiceContents'])->name('get.service.contents');
    Route::post('/delete_service_content', [ServicesController::class, 'deleteServiceContent'])->name('delete.service.content');

    Route::get('/check_blog_link/{blog_url}/{id?}', [BlogsController::class, 'checkBlogLink'])->name('check.blog.link');
    Route::get('/manage_blogs', [BlogsController::class, 'manageBlogs'])->name('manage_blogs');
    Route::match(['get', 'post'], '/add_blog', [BlogsController::class, 'addBlog'])->name('add.blog');
    Route::match(['get', 'post'], '/edit_blog/{blog}', [BlogsController::class, 'editBlog'])->name('edit.blog');
    Route::get('/get_blog_section/{blog}', [BlogsController::class, 'getBlogSection'])->name('get.blog.section');
    Route::match(['get', 'post'], '/delete_blog_section', [BlogsController::class, 'deleteBlogSection'])->name('delete.blog.section');
    Route::match(['get', 'post'], '/change_featured_blog', [BlogsController::class, 'changeFeaturedBlog'])->name('change.featured.blog');

    Route::get('/manage_brands', [BrandsController::class, 'manageBrands'])->name('manage_brands');
    Route::match(['get', 'post'], '/add_brand', [BrandsController::class, 'addBrand'])->name('add.brand');
    Route::match(['get', 'post'], '/edit_brand/{brand}', [BrandsController::class, 'editBrand'])->name('edit.brand');
    Route::get('/brand_data', [BrandsController::class, 'brand_data'])->name('brand.data');
    Route::match(['post', 'delete'], '/brand_delete', [BrandsController::class, 'brand_delete'])->name('brand.delete');

    Route::get('/manage_accommodations', [AccommodationsController::class, 'manageAccommodations'])->name('manage_accommodations');
    Route::get('/accommodation_data', [AccommodationsController::class, 'accommodation_data'])->name('accommodation.data');
    Route::match(['get', 'post'], '/add_accommodation', [AccommodationsController::class, 'addAccommodation'])->name('add.accommodation');
    Route::match(['get', 'post'], '/edit_accommodation/{accommodation}', [AccommodationsController::class, 'editAccommodation'])->name('edit.accommodation');
    Route::match(['post', 'delete'], '/accommodation_delete', [AccommodationsController::class, 'accommodation_delete'])->name('accommodation.delete');

    Route::get('/manage_experiences', [ExperiencesController::class, 'manageExperiences'])->name('manage_experiences');
    Route::get('/experience_data', [ExperiencesController::class, 'experience_data'])->name('experience.data');
    Route::match(['get', 'post'], '/add_experience', [ExperiencesController::class, 'addExperience'])->name('add.experience');
    Route::match(['get', 'post'], '/edit_experience/{experience}', [ExperiencesController::class, 'editExperience'])->name('edit.experience');
    Route::match(['post', 'delete'], '/experience_delete', [ExperiencesController::class, 'experience_delete'])->name('experience.delete');

    Route::get('/manage_events', [EventsController::class, 'manageEvents'])->name('manage_events');
    Route::get('/event_data', [EventsController::class, 'event_data'])->name('event.data');
    Route::match(['get', 'post'], '/add_event', [EventsController::class, 'addEvent'])->name('add.event');
    Route::match(['get', 'post'], '/edit_event/{event}', [EventsController::class, 'editEvent'])->name('edit.event');
    Route::match(['post', 'delete'], '/event_delete', [EventsController::class, 'event_delete'])->name('event.delete');

    Route::get('/manage_testimonials', [TestimonialsController::class, 'manageTestimonials'])->name('manage_testimonials');
    Route::get('/testimonial_data', [TestimonialsController::class, 'testimonial_data'])->name('testimonial.data');
    Route::match(['get', 'post'], '/add_testimonial', [TestimonialsController::class, 'addTestimonial'])->name('add.testimonial');
    Route::match(['get', 'post'], '/edit_testimonial/{testimonial}', [TestimonialsController::class, 'editTestimonial'])->name('edit.testimonial');

    Route::get('/manage_gallery_categories', [GalleryCategoriesController::class, 'manageGalleryCategories'])->name('manage_gallery_categories');
    Route::get('/gallery_category_data', [GalleryCategoriesController::class, 'gallery_category_data'])->name('gallery_category.data');
    Route::match(['get', 'post'], '/add_gallery_category', [GalleryCategoriesController::class, 'addGalleryCategory'])->name('add.gallery_category');
    Route::match(['get', 'post'], '/edit_gallery_category/{gallery_category}', [GalleryCategoriesController::class, 'editGalleryCategory'])->name('edit.gallery_category');

    Route::get('/manage_galleries', [GalleriesController::class, 'manageGalleries'])->name('manage_galleries');
    Route::get('/gallery_data', [GalleriesController::class, 'gallery_data'])->name('gallery.data');
    Route::match(['get', 'post'], '/add_gallery', [GalleriesController::class, 'addGallery'])->name('add.gallery');
    Route::match(['get', 'post'], '/edit_gallery/{gallery}', [GalleriesController::class, 'editGallery'])->name('edit.gallery');

    Route::get('/manage_legal', [LegalController::class, 'manageLegal'])->name('manage_legal');
    Route::match(['get', 'post'], '/edit_legal/{legal}', [LegalController::class, 'editLegal'])->name('edit.legal');

    Route::get('/manage_company', [CompanyController::class, 'manageCompany'])->name('manage_company');
    Route::post('/edit_company/{company}', [CompanyController::class, 'editCompany'])->name('edit.company');
    Route::get('/manage_contact', [CompanyController::class, 'manageContact'])->name('manage_contact');
    Route::post('/edit_contact/{contact}', [CompanyController::class, 'editContact'])->name('edit.contact');
    Route::get('/manage_socials', [CompanyController::class, 'manageSocials'])->name('manage_socials');
    Route::post('/edit_socials/{socials}', [CompanyController::class, 'editSocials'])->name('edit.socials');

    Route::get('/manage_contact_form', [FormController::class, 'manage_contact_form'])->name('manage_contact_form');
    Route::get('/contactform-data', [FormController::class, 'contactform_data'])->name('contactform.data');
    Route::get('/contactform-data/{id}', [FormController::class, 'contactform_detail'])->name('contactform_detail');
    Route::post('/contactform-delete', [FormController::class, 'contactform_delete'])->name('contactform.delete');
    Route::post('/contactform-status', [FormController::class, 'contactform_status'])->name('contactform.status');
});
