<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
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
                    'user_id' => [
                        'required',
                        'integer',
                        Rule::exists(User::class, 'id'),
                    ],
                    'products' => 'required|array',
                    'products.*.id' => [
                        'required',
                        'integer',
                        Rule::exists(Product::class, 'id'),
                    ],
                    'products.*.quantity' => 'required|integer',
                ];
                break;

            default:
                return [];
                break;
        }
    }
}
