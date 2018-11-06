<?php

namespace App\Http\Requests;

use App\Models\Domain;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDomain extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'domain' => 'required|max:255|unique:domains|regex:/^(?!:\/\/)(?=.{1,255}$)((.{1,63}\.){1,127}(?![0-9]*$)[a-z0-9-]+\.?)$/i'
        ];
    }

    public function response($errors)
    {

        return response()->json(['status' => 403, 'errors' => $errors]);
    }
}
