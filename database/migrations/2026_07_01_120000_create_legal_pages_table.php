<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('position_order')->default(1);
            $table->string('page_slug')->unique();
            $table->string('page_name');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        DB::table('legal_pages')->insert([
            [
                'position_order' => 1,
                'page_slug' => 'privacy-policy',
                'page_name' => 'Privacy Policy',
                'title' => 'Privacy Policy',
                'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et ligula nec justo tincidunt pulvinar. Vestibulum ante ipsum primis in faucibus.</p><h3>Information We Collect</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et ligula nec justo tincidunt pulvinar. Vestibulum ante ipsum primis in faucibus.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. <a href="tel:+1234567890">12345 67890</a> Suspendisse potenti. Integer feugiat magna non <em>justo elementum, eget feugiat nunc interdum.</em></p><h3>How We Use Information</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur et ligula nec justo tincidunt pulvinar. Vestibulum ante ipsum primis in faucibus.</p><h3>Cookies &amp; Tracking</h3><p>Lorem ipsum dolor sit amet, <em>consectetur adipiscing elit. Morbi</em> faucibus felis non orci pretium, vitae volutpat nisi viverra.</p><h3>Third Party Services</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p><h3>Your Rights</h3><p>Lorem ipsum dolor sit amet, <a href="#">consectetur adipiscing elit.</a> Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>',
                'meta_title' => 'Privacy Policy | Whispering Pines',
                'meta_keyword' => null,
                'meta_description' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position_order' => 2,
                'page_slug' => 'terms-conditions',
                'page_name' => 'Terms & Conditions',
                'title' => 'Terms & Conditions',
                'description' => null,
                'meta_title' => 'Terms & Conditions | Whispering Pines',
                'meta_keyword' => null,
                'meta_description' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'position_order' => 3,
                'page_slug' => 'reservation-cancellation-refund',
                'page_name' => 'Reservation, Cancellation & Refund Policy',
                'title' => 'Reservation, Cancellation & Refund Policy',
                'description' => null,
                'meta_title' => 'Reservation, Cancellation & Refund Policy | Whispering Pines',
                'meta_keyword' => null,
                'meta_description' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_pages');
    }
};
