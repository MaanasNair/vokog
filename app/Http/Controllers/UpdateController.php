<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Artisan;
use Schema;
use App\BusinessSetting;
use App\Language;
use App\Category;
use App\Brand;
use App\SubCategory;
use App\SubSubCategory;

class UpdateController extends Controller
{
    public function step0() {
        return view('update.step0');
    }

    public function step1() {
        if(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '1.5'){
            $sql_path = base_path('sqlupdates/v16.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        elseif(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '1.4'){
            $sql_path = base_path('sqlupdates/v15.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v16.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        else{
            $sql_path = base_path('shop_update.sql');
            if(!Schema::hasTable('wallets')){
                DB::unprepared(file_get_contents($sql_path));
            }
            if(!Schema::hasColumn('users', 'balance')){
                DB::unprepared("ALTER TABLE `users` ADD `balance` DOUBLE(8,2) NOT NULL DEFAULT '0' AFTER `phone`");
            }
            if(!Schema::hasColumn('products', 'shipping_type')){
                DB::unprepared("ALTER TABLE `products` ADD `shipping_type` VARCHAR(20) NOT NULL DEFAULT 'flat_rate' AFTER `tax_type`");
            }
            if(!Schema::hasColumn('languages', 'rtl')){
                DB::unprepared("ALTER TABLE `languages` ADD `rtl` INT(1) NOT NULL DEFAULT '0' AFTER `code`");
            }
            if(BusinessSetting::where('type', 'facebook_chat')->first() == null){
                $sql = "INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'facebook_chat', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                DB::unprepared($sql);
            }
            if(Language::where('code', 'sa')->first() == null){
                $sql = "INSERT INTO `languages` (`id`, `name`, `code`, `rtl`, `created_at`, `updated_at`) VALUES (NULL, 'Arabic', 'sa', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                DB::unprepared($sql);
            }
            if (BusinessSetting::where('type', 'email_verification')->first() == null) {
                $sql = "INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'email_verification', '0', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                DB::unprepared($sql);
            }
            if(BusinessSetting::where('type', 'wallet_system')->first() == null){
                $sql = "INSERT INTO `business_settings` (`id`, `type`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'wallet_system', '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
                DB::unprepared($sql);
            }
            if(!Schema::hasColumn('shops', 'instagram')){
                DB::unprepared("ALTER TABLE `shops` ADD `instagram` VARCHAR(255) NULL DEFAULT NULL AFTER `youtube`");
            }
            if(!Schema::hasTable('coupons')){
                $sql_path = base_path('shop_update_14.sql');
                DB::unprepared(file_get_contents($sql_path));
            }
            $sql_path = base_path('sqlupdates/v15.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v16.sql');
            DB::unprepared(file_get_contents($sql_path));
        }

        return redirect('step2');
    }

    public function step2() {
        Artisan::call('view:clear');

        foreach (Category::all() as $key => $value) {
            $value->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $value->name));
            $value->meta_title = $value->name;
            $value->save();
        }

        foreach (SubCategory::all() as $key => $value) {
            $value->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $value->name));
            $value->meta_title = $value->name;
            $value->save();
        }

        foreach (SubSubCategory::all() as $key => $value) {
            $value->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $value->name));
            $value->meta_title = $value->name;
            $value->save();
        }

        foreach (Brand::all() as $key => $value) {
            $value->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $value->name));
            $value->meta_title = $value->name;
            $value->save();
        }

        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        return view('update.done');
    }
}
