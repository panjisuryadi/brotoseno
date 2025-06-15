<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Http\Requests\StoreSettingsRequest;
use Modules\Setting\Http\Requests\StoreSmtpSettingsRequest;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function index() {
        abort_if(Gate::denies('access_settings'), 403);

        $settings = Setting::firstOrFail();

        return view('setting::index', compact('settings'));
    }

    public function update(StoreSettingsRequest $request) {
           $settings       = Setting::findOrFail(1);
           $params = $request->all();
           //dd($params);
           $params = $request->except('_token');
           $params['company_name'] = $params['company_name'];
           $params['company_email'] = $params['company_email'];
           $params['bg_sidebar'] = $params['bg_sidebar'];
           $params['bg_sidebar_hover'] = $params['bg_sidebar_hover'];
           $params['bg_sidebar_aktif'] = $params['bg_sidebar_aktif'];
           $params['bg_sidebar_link'] = $params['bg_sidebar_link'];
           $params['bg_sidebar_link_hover'] = $params['bg_sidebar_link_hover'];
           $params['link_color'] = $params['link_color'];
           $params['link_hover'] = $params['link_hover'];
           $params['link_color'] = $params['link_color'];
           $params['header_color'] = $params['header_color'];
           $params['btn_color'] = $params['btn_color'];
           $params['cabang_id'] = $params['cabang_id'];

               if ($request->hasFile('site_logo')) {
                    $file = $request->file('site_logo');
                    if ($file->isValid()) {
                         $newFilename = 'logo_'.date('YmdHis') . "." . $file->getClientOriginalExtension();
                        $normalpath = 'logo/' . $newFilename;
                        Storage::disk('public')->put($normalpath, file_get_contents($file));
                        $params['site_logo'] = "$newFilename";
                                    }
                }else{
                    unset($params['site_logo']);

                  }

       if ($request->hasFile('small_logo')) {
            $file = $request->file('small_logo');
            if ($file->isValid()) {
                 $newFilename = 'logo_'.date('YmdHis') . "." . $file->getClientOriginalExtension();
                $normalpath = 'logo/' . $newFilename;
                Storage::disk('public')->put($normalpath, file_get_contents($file));
                $params['small_logo'] = "$newFilename";
                            }
        }else{
            unset($params['small_logo']);

          }

          $settings->update($params);

        cache()->forget('settings');
        toast('Settings Updated!', 'info');

        return redirect()->route('settings.index');
    }


    public function updateSmtp(StoreSmtpSettingsRequest $request) {
        $toReplace = array(
            'MAIL_MAILER='.env('MAIL_HOST'),
            'MAIL_HOST="'.env('MAIL_HOST').'"',
            'MAIL_PORT='.env('MAIL_PORT'),
            'MAIL_FROM_ADDRESS="'.env('MAIL_FROM_ADDRESS').'"',
            'MAIL_FROM_NAME="'.env('MAIL_FROM_NAME').'"',
            'MAIL_USERNAME="'.env('MAIL_USERNAME').'"',
            'MAIL_PASSWORD="'.env('MAIL_PASSWORD').'"',
            'MAIL_ENCRYPTION="'.env('MAIL_ENCRYPTION').'"'
        );

        $replaceWith = array(
            'MAIL_MAILER='.$request->mail_mailer,
            'MAIL_HOST="'.$request->mail_host.'"',
            'MAIL_PORT='.$request->mail_port,
            'MAIL_FROM_ADDRESS="'.$request->mail_from_address.'"',
            'MAIL_FROM_NAME="'.$request->mail_from_name.'"',
            'MAIL_USERNAME="'.$request->mail_username.'"',
            'MAIL_PASSWORD="'.$request->mail_password.'"',
            'MAIL_ENCRYPTION="'.$request->mail_encryption.'"');

        try {
            file_put_contents(base_path('.env'), str_replace($toReplace, $replaceWith, file_get_contents(base_path('.env'))));
            Artisan::call('cache:clear');

            toast('Mail Settings Updated!', 'info');
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('settings_smtp_message', 'Something Went Wrong!');
        }

        return redirect()->route('settings.index');
    }
}
