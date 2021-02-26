<?php

namespace LambdaDigamma\MMFeeds\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublishPost extends FormRequest
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
            'published_at' => 'nullable|date|after_or_equal:now',
        ];
    }
}
