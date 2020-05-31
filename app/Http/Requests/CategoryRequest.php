<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|unique:categories|regex:/^[A-Za-z0-9._\s-]+$/',
            'slug' => 'required|unique:categories|regex:/^[A-Za-z0-9-]+$/',
            'folder_id' => 'nullable'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => 'Nama sudah ada',
            'name.regex' => 'Karakter yang diperbolehkan adalah a-z, A-Z, 0-9, titik (.), underscore (_), tanda pisah (-), dan spasi',
            'slug.unique' => 'Slug sudah ada',
            'slug.regex' => 'Karakter yang diperbolehkan adalah a-z, A-Z, 0-9, dan tanda pisah (-)',
        ];
    }
}
