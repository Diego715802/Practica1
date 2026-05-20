<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Importante para que no bloquee la petición
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:200|unique:posts,title,' . $this->route('post'),
            'content' => 'required|string|min:50',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array|min:1|max:5',
            'tags.*' => 'exists:tags,id',
            'published_at' => 'nullable|date|after:today',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio',
            'title.min' => 'El título debe tener al menos 5 caracteres',
            'content.min' => 'El contenido debe tener al menos 50 caracteres',
            'tags.min' => 'Debes seleccionar al menos 1 etiqueta',
        ];
    }
}
