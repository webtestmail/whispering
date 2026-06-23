<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    function manageCompany()
    {
        $company = Company::select('id', 'company_icon', 'company_logo', 'company_footer_logo', 'company_name', 'get_updates_section', 'footer_content_visibility', 'footer_content', 'copyright')->findOrFail(1);
        $company->encrypted_id = Crypt::encrypt($company->id);

        $main_page = "settings";
        $currentPage = "company";
        return view('admin.manage_company', ['company' => $company, "main_page" => $main_page, "currentPage" => $currentPage]);
    }

    function manageContact()
    {
        $contact = Company::select('id', 'phone', 'whatsapp_phone', 'alternate_phone', 'email', 'alternate_email', 'footer_location', 'location', 'alternate_location', 'map_link_visibility', 'map_link', 'newsletter_title', 'newsletter_description', 'newsletter_image', 'newsletter_success_msg')->findOrFail(1);
        $contact->encrypted_id = Crypt::encrypt($contact->id);

        $main_page = "settings";
        $currentPage = "contact";
        return view('admin.manage_contact', ['contact' => $contact, "main_page" => $main_page, "currentPage" => $currentPage]);
    }

    function manageSocials()
    {
        $socials = Company::select('id', 'socials_visibility', 'facebook_url', 'x_url', 'linkedin_url', 'youtube_url', 'instagram_url')->findOrFail(1);
        $socials->encrypted_id = Crypt::encrypt($socials->id);

        $main_page = "settings";
        $currentPage = "socials";
        return view('admin.manage_socials', ['socials' => $socials, "main_page" => $main_page, "currentPage" => $currentPage]);
    }

    function editCompany(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
        ], [
            'company_name.required' => 'Comapny Name is required!',
            'company_name.string' => 'Comapny Name should be string!',
        ]);

        $id = Crypt::decrypt($request->company);
        $company = Company::findOrFail($id);
        $company->company_name = $request->company_name;
        $company->get_updates_section = $request->get_updates_section;
        $company->copyright = $request->copyright;
        $company->footer_content_visibility = $request->footer_content_visibility;
        if ($request->footer_content_visibility == 'yes') {
            $company->footer_content = $request->footer_content;
        }

        $path = 'images/company/';
        if (!empty($request->file('company_icon'))) {
            $filePath = $this->storeImage($request->file("company_icon"), $path, $company->company_icon);
            $company->company_icon = $filePath;
        }
        if (!empty($request->file('company_logo'))) {
            $filePath = $this->storeImage($request->file("company_logo"), $path, $company->company_logo);
            $company->company_logo = $filePath;
        }
        if (!empty($request->file('company_footer_logo'))) {
            $filePath = $this->storeImage($request->file("company_footer_logo"), $path, $company->company_footer_logo);
            $company->company_footer_logo = $filePath;
        }

        if ($company->save()) {
            $request->session()->flash('success', 'Company data is updated Successfully!');
            return redirect()->route('admin.manage_company');
        } else {
            $request->session()->flash('error', 'Updation Error!');
            return redirect()->route('admin.edit.company', $request->company);
        }
    }

    function editContact(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'mail' => 'required|email',
        ], [
            'phone.required' => 'Phone Number is required!',
            'phone.string' => 'Phone Number should be string format!',
            'mail.required' => 'E-Mail is required!',
            'mail.email' => 'Invalid E-Mail!',
        ]);

        $id = Crypt::decrypt($request->contact);
        $contact = Company::findOrFail($id);
        $contact->phone = $request->phone;
        $contact->whatsapp_phone = $request->whatsapp_phone;
        $contact->alternate_phone = $request->alternate_phone;
        $contact->email = $request->mail;
        $contact->alternate_email = $request->alternate_email;
        $contact->footer_location = $request->footer_location;
        $contact->location = htmlspecialchars($request->location);
        $contact->alternate_location = htmlspecialchars($request->alternate_location);
        $contact->map_link_visibility = $request->map_link_visibility;
        $contact->newsletter_title = $request->newsletter_title;
        $contact->newsletter_description = $request->newsletter_description;
        $contact->newsletter_success_msg = $request->newsletter_success_msg;

          if (!empty($request->file('newsletter_image'))) {
                    $path = 'images/company/';
                    $filePath = $this->storeImage($request->file('newsletter_image'), $path);
                    $contact['newsletter_image'] = $filePath;
                }


        if ($request->map_link_visibility == 'yes') {
            $contact->map_link = htmlspecialchars($request->map_link);
        }

        if ($contact->save()) {
            $request->session()->flash('success', 'Contact data is updated Successfully!');
            return redirect()->route('admin.manage_contact');
        } else {
            $request->session()->flash('error', 'Updation Error!');
            return redirect()->route('admin.edit.contact', $request->contact);
        }
    }

    function editSocials(Request $request)
    {
        $id = Crypt::decrypt($request->socials);
        $socials = Company::findOrFail($id);
        $socials->facebook_url = $request->facebook_url;
        $socials->x_url = $request->x_url;
        $socials->linkedin_url = $request->linkedin_url;
        $socials->youtube_url = $request->youtube_url;
        $socials->instagram_url = $request->instagram_url;

        if ($socials->save()) {
            $request->session()->flash('success', 'Socials data is updated Successfully!');
            return redirect()->route('admin.manage_socials');
        } else {
            $request->session()->flash('error', 'Updation Error!');
            return redirect()->route('admin.edit.socials', $request->socials);
        }
    }

    function getCompanyData()
    {
        return Company::findOrFail(1);
    }
}
