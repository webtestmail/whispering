<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appearance;
use App\Models\Brand;
use App\Models\CompanyLink;
use App\Models\Country;
use App\Models\MemberCategory;
use App\Models\MemberCompanyContact;
use App\Models\PointOfContact;
use App\Models\ProductCategory;
use App\Models\Temperature;
use App\Models\TradeSector;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function user_edit($id, Request $request)
    {
        $user = User::with([
            'userprofile',
            'tradeSectors',
            'productCategories',
            'productSubCategories',
            'temperatures',
            'brands',
            'companylinks',
            'mainPointOfContact',
            'pointOfContact',
            'appearance',
        ])->findOrFail(Crypt::decrypt($request->id));

        if ($request->isMethod('post')) {
            return $this->updateUser($request, $user);
        }

        return view('admin.users-ops', $this->userEditViewData($user, $request->id));
    }

    public function manageUsers()
    {
        $users = User::with('userprofile')->get();
        foreach ($users as $user) {
            $user->encrypted_id = Crypt::encrypt($user->id);
        }

        $model = Crypt::encrypt('User');
        $currentPage = 'manage_users';

        return view('admin.manage_users', ['users' => $users, 'model' => $model, 'currentPage' => $currentPage]);
    }

    public function user_data()
    {
        $user = User::query()->with('userprofile');

        return DataTables::of($user)
            ->addIndexColumn()
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->addColumn('company', function ($user) {
                return $user->userprofile?->company_name ?? '—';
            })
            ->addColumn('role', function ($user) {
                return $this->roleLabel($user->role);
            })
            ->addColumn('email', function ($user) {
                return $user->email;
            })
            ->addColumn('phone', function ($user) {
                return $user->phone;
            })
            ->addColumn('is_active', function ($user) {
                return $user->is_active == true ? 'Active' : 'In active';
            })
            ->addColumn('action', function ($user) {
                return '<div class="dropdown">
                            <a href="javascript:void(0);" class="avatar-text avatar-md ms-auto" data-bs-toggle="dropdown">
                                <i class="feather-more-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="' . route('admin.user.edit', encrypt($user->id)) . '" class="dropdown-item">Modify</a>
                                <button class="dropdown-item delete" data-id="' . $user->id . '">Delete User</button>
                            </div>
                        </div>';
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('d M, Y');
            })
            ->rawColumns(['action', 'name', 'is_active', 'role', 'company'])
            ->make(true);
    }

    public function deleteUser(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',
        ]);

        $user = User::findOrFail((int) $request->id);
        if ((int) auth()->id() === (int) $user->id) {
            throw ValidationException::withMessages([
                'id' => 'You cannot delete your own account while logged in.',
            ]);
        }

        $user->delete();

        return response()->json([
            'status' => 'done',
            'message' => 'User deleted successfully.',
        ]);
    }

    private function userEditViewData(User $user, string $encryptedId): array
    {
        $user->encrypted_id = $encryptedId;

        $allContacts = MemberCompanyContact::query()
            ->where('user_id', $user->id)
            ->orderBy('id')
            ->get();

        $primaryCompanyContact = $allContacts->first(function (MemberCompanyContact $row) {
            $flag = $row->getAttribute('is_main');

            return $flag === 1 || $flag === true || $flag === '1';
        });

        if ($primaryCompanyContact === null && $allContacts->isNotEmpty()) {
            $primaryCompanyContact = $allContacts->first();
        }

        $extraCompanyContacts = $allContacts
            ->when($primaryCompanyContact, function ($collection) use ($primaryCompanyContact) {
                return $collection->reject(fn (MemberCompanyContact $row) => (int) $row->id === (int) $primaryCompanyContact->id);
            })
            ->values();

        return [
            'user' => $user,
            'currentPage' => 'manage_users',
            'memberCategories' => MemberCategory::active()->orderBy('name')->get(),
            'countries' => Country::active()->orderBy('name')->get(),
            'trade_sectors' => TradeSector::active()->get(),
            'product_categories' => ProductCategory::active()
                ->with(['subCategories' => fn ($q) => $q->where('is_active', true)->orderBy('name')])
                ->orderBy('name')
                ->get(),
            'temperatures' => Temperature::active()->get(),
            'primaryCompanyContact' => $primaryCompanyContact,
            'extraCompanyContacts' => $extraCompanyContacts,
        ];
    }

    private function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:50',
            'role' => 'nullable|integer|in:0,1,2,3,4',
            'password' => 'nullable|string|min:8|confirmed',
            'company_name' => 'nullable|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'organization_type' => 'nullable|string|max:255',
            'employee_count' => 'nullable|integer|min:0',
            'country_id' => 'nullable|integer|exists:countries,id',
            'company_description' => 'nullable|string',
            'profile_is_active' => 'nullable|boolean',
            'trade' => 'nullable|array',
            'trade.*' => 'integer|exists:trade_sectors,id',
            'product_category' => 'nullable|array',
            'product_category.*' => 'integer|exists:product_categories,id',
            'product_sub_category' => 'nullable|array',
            'product_sub_category.*' => 'integer|exists:product_sub_categories,id',
            'temperature' => 'nullable|array',
            'temperature.*' => 'integer|exists:temperatures,id',
            'brands' => 'nullable|string|max:2000',
            'website_url' => 'nullable|string|max:2048',
            'linkedin_url' => 'nullable|string|max:2048',
            'facebook_url' => 'nullable|string|max:2048',
            'twitter_urls' => 'nullable|string|max:2048',
            'instagram_url' => 'nullable|string|max:2048',
            'youtube_url' => 'nullable|string|max:2048',
            'pinterest_url' => 'nullable|string|max:2048',
            'whatsapp_url_or_number' => 'nullable|string|max:255',
            'main_address' => 'nullable|string|max:2000',
            'map_url' => 'nullable|string|max:2000',
            'country' => 'nullable|string|max:255',
            'extra_addresses' => 'nullable|array',
            'extra_addresses.*' => 'nullable|string|max:2000',
            'extra_map_urls' => 'nullable|array',
            'extra_map_urls.*' => 'nullable|string|max:2000',
            'extra_countries' => 'nullable|array',
            'extra_countries.*' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_surname' => 'nullable|string|max:255',
            'contact_position' => 'nullable|string|max:255',
            'contact_gender' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'main_contact_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'remove_main_contact_image' => 'nullable|boolean',
            'extra_names' => 'nullable|array',
            'extra_names.*' => 'nullable|string|max:255',
            'extra_surnames' => 'nullable|array',
            'extra_surnames.*' => 'nullable|string|max:255',
            'extra_positions' => 'nullable|array',
            'extra_positions.*' => 'nullable|string|max:255',
            'extra_genders' => 'nullable|array',
            'extra_genders.*' => 'nullable|string|max:255',
            'extra_emails' => 'nullable|array',
            'extra_emails.*' => 'nullable|email|max:255',
            'extra_phones' => 'nullable|array',
            'extra_phones.*' => 'nullable|string|max:50',
            'extra_existing_images' => 'nullable|array',
            'extra_existing_images.*' => 'nullable|string|max:500',
            'extra_images' => 'nullable|array',
            'extra_images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'custom_link_captions' => 'nullable|array|max:10',
            'custom_link_captions.*' => 'nullable|string|max:12',
            'custom_link_urls' => 'nullable|array|max:10',
            'custom_link_urls.*' => 'nullable|string|max:2048',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'promo_banner_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'promo_banner_image_mobile' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'remove_company_logo' => 'nullable|boolean',
            'remove_cover_image' => 'nullable|boolean',
            'remove_promo_banner_image' => 'nullable|boolean',
            'remove_promo_banner_image_mobile' => 'nullable|boolean',
            'promo_banner' => 'nullable|in:yes,no',
            'promo_banner_link' => 'nullable|string|max:2048',
        ]);

        try {
            DB::transaction(function () use ($request, $user, $validated) {
                $user->name = $validated['name'];
                $user->username = $validated['username'] ?? $user->username;
                $user->email = $validated['email'];
                $user->phone = $validated['phone'];
                $user->is_active = $request->user_status == 1 ? 1 : 0;

                if (array_key_exists('role', $validated) && $validated['role'] !== null) {
                    $user->role = (int) $validated['role'];
                }

                if (! empty($validated['password'])) {
                    $user->password = Hash::make($validated['password']);
                }

                $user->save();

                $companyName = $validated['company_name'] ?? $user->userprofile?->company_name;
                $user->userprofile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'company_name' => $companyName,
                        'slug' => $companyName ? Str::slug($companyName) : ($user->userprofile?->slug),
                        'slogan' => $validated['slogan'] ?? null,
                        'company_type' => $validated['organization_type'] ?? null,
                        'number_of_employees' => $validated['employee_count'] ?? null,
                        'country_id' => $validated['country_id'] ?? null,
                        'company_description' => $validated['company_description'] ?? null,
                        'is_active' => $request->boolean('profile_is_active') ? 1 : 0,
                    ]
                );

                $user->tradeSectors()->sync($validated['trade'] ?? []);
                $user->productCategories()->sync(array_values(array_filter($validated['product_category'] ?? [])));
                $user->productSubCategories()->sync(array_values(array_filter($validated['product_sub_category'] ?? [])));
                $user->temperatures()->sync($validated['temperature'] ?? []);

                $brandNames = array_filter(array_map('trim', explode(',', (string) ($validated['brands'] ?? ''))));
                $brandIds = [];
                foreach ($brandNames as $brandName) {
                    $brandIds[] = Brand::firstOrCreate(['name' => $brandName])->id;
                }
                $user->brands()->sync($brandIds);

                $customLinks = $this->buildCustomLinks(
                    $validated['custom_link_captions'] ?? [],
                    $validated['custom_link_urls'] ?? []
                );

                CompanyLink::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'website_url' => $validated['website_url'] ?? null,
                        'linkedin_url' => $validated['linkedin_url'] ?? null,
                        'facebook_url' => $validated['facebook_url'] ?? null,
                        'twitter_url' => $validated['twitter_urls'] ?? null,
                        'instagram_url' => $validated['instagram_url'] ?? null,
                        'youtube_url' => $validated['youtube_url'] ?? null,
                        'pinterest_url' => $validated['pinterest_url'] ?? null,
                        'whatsapp_url_or_number' => $validated['whatsapp_url_or_number'] ?? null,
                        'custom_links' => $customLinks !== [] ? $customLinks : null,
                    ]
                );

                if (! empty($validated['main_address']) || ! empty($validated['country'])) {
                    MemberCompanyContact::updateOrCreate(
                        ['user_id' => $user->id, 'is_main' => 1],
                        [
                            'main_address' => $validated['main_address'] ?? null,
                            'google_map_link' => $validated['map_url'] ?? null,
                            'country' => $validated['country'] ?? null,
                            'is_active' => 1,
                        ]
                    );
                }

                MemberCompanyContact::where('user_id', $user->id)->where('is_main', 0)->delete();
                foreach ($validated['extra_addresses'] ?? [] as $index => $address) {
                    if (empty($address)) {
                        continue;
                    }

                    MemberCompanyContact::create([
                        'user_id' => $user->id,
                        'main_address' => $address,
                        'google_map_link' => data_get($validated, "extra_map_urls.$index"),
                        'country' => data_get($validated, "extra_countries.$index"),
                        'is_active' => 1,
                        'is_main' => 0,
                    ]);
                }

                if (! empty($validated['contact_name']) || ! empty($validated['contact_email']) || ! empty($validated['contact_phone'])) {
                    $mainContact = PointOfContact::updateOrCreate(
                        ['user_id' => $user->id, 'is_primary' => 1],
                        [
                            'contact_name' => $validated['contact_name'] ?? null,
                            'contact_surname' => $validated['contact_surname'] ?? null,
                            'contact_position' => $validated['contact_position'] ?? null,
                            'contact_gender' => $validated['contact_gender'] ?? null,
                            'contact_email' => $validated['contact_email'] ?? null,
                            'contact_phone' => $validated['contact_phone'] ?? null,
                            'is_active' => 1,
                        ]
                    );

                    if ($request->hasFile('main_contact_image')) {
                        $this->deletePublicStorageFile($mainContact->image);
                        $mainContact->update([
                            'image' => $request->file('main_contact_image')->store('contacts', 'public'),
                        ]);
                    } elseif ($this->requestWantsImageRemoved($request, 'remove_main_contact_image')) {
                        $this->deletePublicStorageFile($mainContact->image);
                        $mainContact->update(['image' => null]);
                    }
                }

                $this->syncExtraPointOfContacts($request, $user);
                $this->syncAppearance($request, $user);
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Error updating user: ' . $e->getMessage());
        }

        return back()->with('success', 'User profile updated successfully.');
    }

    private function roleLabel(mixed $role): string
    {
        return match ((int) $role) {
            User::ROLE_MEMBER => 'Member',
            User::ROLE_ADMIN => 'Admin',
            User::ROLE_SUBMEMBER => 'Sub Member',
            User::ROLE_SUBSUBMEMBER => 'Sub Sub Member',
            User::ROLE_SUBADMIN => 'Sub Admin',
            default => (string) $role,
        };
    }

    private function buildCustomLinks(array $captions, array $urls): array
    {
        $customLinks = [];
        $count = max(count($captions), count($urls));

        for ($i = 0; $i < $count && count($customLinks) < 10; $i++) {
            $caption = isset($captions[$i]) ? trim((string) $captions[$i]) : '';
            $url = isset($urls[$i]) ? trim((string) $urls[$i]) : '';

            if ($caption === '' && $url === '') {
                continue;
            }

            if ($caption === '' || $url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
                continue;
            }

            $customLinks[] = ['caption' => $caption, 'url' => $url];
        }

        return $customLinks;
    }

    private function syncExtraPointOfContacts(Request $request, User $user): void
    {
        $oldContacts = PointOfContact::where('user_id', $user->id)->where('is_primary', 0)->get();
        $existingImages = $request->input('extra_existing_images', []);

        foreach ($oldContacts as $oldContact) {
            if ($oldContact->image && ! in_array($oldContact->image, $existingImages, true)) {
                $this->deletePublicStorageFile($oldContact->image);
            }
        }

        PointOfContact::where('user_id', $user->id)->where('is_primary', 0)->delete();

        $allKeys = array_unique(array_merge(
            array_keys($request->input('extra_names', [])),
            array_keys($request->input('extra_phones', [])),
            array_keys($request->input('extra_emails', []))
        ));

        foreach ($allKeys as $key) {
            $name = $request->input("extra_names.$key");
            $phone = $request->input("extra_phones.$key");
            $email = $request->input("extra_emails.$key");

            if (empty($name) && empty($phone) && empty($email)) {
                continue;
            }

            $imagePath = null;
            if ($request->hasFile("extra_images.$key")) {
                $imagePath = $request->file("extra_images.$key")->store('contacts', 'public');
            } elseif (! empty($existingImages[$key]) && is_string($existingImages[$key]) && ! str_contains($existingImages[$key], '..')) {
                $imagePath = $existingImages[$key];
            }

            PointOfContact::create([
                'user_id' => $user->id,
                'is_primary' => 0,
                'contact_name' => $name,
                'contact_surname' => $request->input("extra_surnames.$key"),
                'contact_position' => $request->input("extra_positions.$key"),
                'contact_email' => $email,
                'contact_gender' => $request->input("extra_genders.$key"),
                'contact_phone' => $phone,
                'is_active' => 1,
                'image' => $imagePath,
            ]);
        }
    }

    private function syncAppearance(Request $request, User $user): void
    {
        $appearance = Appearance::updateOrCreate(['user_id' => $user->id]);

        $this->handleProfileImageUpload($request, $appearance, 'company_logo', 'company_logo', 'remove_company_logo', 'logos');
        $this->handleProfileImageUpload($request, $appearance, 'cover_image', 'company_cover_image', 'remove_cover_image', 'covers');
        $this->handleProfileImageUpload($request, $appearance, 'promo_banner_image', 'promotional_banner', 'remove_promo_banner_image', 'banners');
        $this->handleProfileImageUpload($request, $appearance, 'promo_banner_image_mobile', 'promotional_banner_mobile', 'remove_promo_banner_image_mobile', 'banners/mobile');

        $appearance->display_cover_image = $request->input('promo_banner') === 'yes';
        if ($request->filled('promo_banner_link')) {
            $appearance->promotional_banner_link = $request->input('promo_banner_link');
        }

        $appearance->save();
    }

    private function requestWantsImageRemoved(Request $request, string $field): bool
    {
        return in_array($request->input($field), ['1', 1, true, 'true'], true);
    }

    private function deletePublicStorageFile(?string $path): void
    {
        if (! $path || str_contains($path, '..')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    private function handleProfileImageUpload(
        Request $request,
        Appearance $profile,
        string $uploadField,
        string $dbColumn,
        string $removeField,
        string $storageFolder
    ): void {
        if ($request->hasFile($uploadField)) {
            $this->deletePublicStorageFile($profile->{$dbColumn});
            $profile->{$dbColumn} = $request->file($uploadField)->store($storageFolder, 'public');

            return;
        }

        if ($this->requestWantsImageRemoved($request, $removeField)) {
            $this->deletePublicStorageFile($profile->{$dbColumn});
            $profile->{$dbColumn} = null;
        }
    }
}
