<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                return [
                        'name' => 'sometimes|string|max:255',
                        'email' => 'sometimes|email|max:255',
                        'password' => 'sometimes|string|min:8',
                ];
                break;

            case 'POST':
                return [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|max:255',
                    'password' => 'required|string|min:8',
                ];
                break;

            default:
                return [];
                break;
        }
    }
}
