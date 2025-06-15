<?php

namespace Modules\Adjustment\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Modules\Adjustment\Entities\AdjustmentSetting;

class AdjustmentSettingController extends Controller{


    public function destroy(){
        // abort_if(Gate::denies('delete_adjustments'), 403);
        $cabang = null;
        if(auth()->user()->isUserCabang()){
            $cabang = auth()->user()->namacabang()->id;
        }
        $setting = AdjustmentSetting::where(
            [
                'cabang_id' => $cabang,
                'status' => 1
            ]);
        $setting->delete();

        return response()->json([
            'message' => 'Adjustment Berhasil dihentikan',
            'redirectRoute' => route('adjustments.index')
        ]);
    }
}
