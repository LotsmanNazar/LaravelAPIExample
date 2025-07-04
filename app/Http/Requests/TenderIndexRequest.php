<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TenderIndexRequest extends FormRequest
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
			'cursor' => 'nullable|string',
			'search_by_name' => 'nullable|string|min:1',
			'search_by_date_start' => 'nullable|date_format:Y-m-d H:i:s|before:search_by_date_end',
			'search_by_date_end' => 'nullable|date_format:Y-m-d H:i:s|after:search_by_date_start'
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
