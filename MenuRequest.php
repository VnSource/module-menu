<?php namespace VnsModules\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'slug' => 'required',
            'target' => 'required',
            'title' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>  __('This is a required field.'),
            'slug.required' =>  __('This is a required field.'),
            'target.required' =>  __('This is a required field.'),
            'title.required' =>  __('This is a required field.'),
        ];
    }

}