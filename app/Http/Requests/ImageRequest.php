<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class ImageRequest extends FormRequest
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
        $rules = [
            'album_id' => 'required|integer',
        ];

        if (Route::is('dashboard.images.store')) {
            $rules['image.*'] = 'required|image';
        } else {
            $rules['path'] = 'required';
        }

        return $rules;
    }
}
