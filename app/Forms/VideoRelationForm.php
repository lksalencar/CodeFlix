<?php

namespace CodeFlix\Forms;

use CodeFlix\Models\Category;
use CodeFlix\Models\Serie;
use Kris\LaravelFormBuilder\Form;

class VideoRelationForm extends Form
{
    public function buildForm()
    {
        $this->add('categories', 'entity', [
            'class' => Category::class,
            'property' => 'name',
            'selected' => $this->model ? $this->model->categories->pluck('id')->toArray() : null,
            'multiple' => true,
            'label' => 'Categorias',
            'attr' => [
                'name' => 'categories[]'
            ],
            'rules' => 'required|exists:categories,id'

        ])->add('serie_id', 'entity', [
            'class' => Serie::class,
            'property' => 'title',
            'empty_value' => 'Selecione a série',
            'label' => 'Séries',
            'rules' => 'nullable|exists:series,id'
        ]);
    }
}
