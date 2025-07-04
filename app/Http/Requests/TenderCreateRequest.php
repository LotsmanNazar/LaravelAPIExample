<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TenderCreateRequest extends FormRequest
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
		return [
			'external_code' => 'required|string|min:1',
			'number' => 'required|string|min:1',
			'status' => 'required|string|min:1',
			'name' => 'required|string|min:1',
			'change_date' => 'required|date_format:Y-m-d H:i:s'
		];
	}

	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json([
			'error' => true,
			'message' => $validator->errors()->first()
		], 422));
	}
}
