<?php

namespace Modules\Purchase\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class StorePurchaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'supplier_id' => 'numeric',
            'reference' => 'required|string|max:255',
            'kode_sales' => ['required',
                  function ($attribute, $value, $fail) {
                            $user = User::where('kode_user', $value)->first();
                            if (!$user) {
                                $fail('Kode Sales tidak ada..!!.');
                            }
                  },],
            'shipping_amount' => 'required|numeric',
            'total_amount' => 'required|numeric',
            'paid_amount' => 'required|numeric',
            'payment_method' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create_sales');
    }
}
