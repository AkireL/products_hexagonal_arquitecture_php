<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        switch ($this->method()) {
            case 'PUT':
            case 'POST':
                return [
                    'name' => 'required|string|max:255',
                    'description' => 'required|nullable|max:255',
                    'stock' => 'required|decimal:0,2',
                    'unit_price' => 'required|decimal:0,2|min:0',
                ];
                break;

            default:
                return [];
                break;
        }
    }
}
