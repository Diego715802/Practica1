<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostWithAttachmentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ¡Muy importante que sea true!
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:200',
            'content' => 'required|string|min:50',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array|min:1|max:5',
            'tags.*' => 'exists:tags,id',
            'attachments' => 'array|max:5',
            'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio',
            'content.min' => 'El contenido debe tener al menos 50 caracteres',
            'attachments.max' => 'No puedes subir más de 5 archivos',
            'attachments.*.max' => 'Cada archivo no debe superar 5MB',
            'attachments.*.mimes' => 'Solo se aceptan JPG, PNG, PDF, DOC, DOCX',
        ];
    }
}
