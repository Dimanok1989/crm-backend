<?php

namespace App\Http\Controllers;

use App\Enums\Fields\FieldType;
use App\Http\Resources\Fields\FieldResource;
use App\Http\Resources\Fields\FieldTypeResource;
use App\Http\Services\Fields\FieldService;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class FieldsController extends Controller
{
    /**
     * Инициализация контроллера
     * 
     * @param \App\Http\Services\Fields\FieldService $service
     * @return void
     */
    public function __construct(
        protected FieldService $service
    ) {
        //
    }

    /**
     * Список полей
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $fields = $this->service->list(
            $request->user(),
            $request->type
        );

        return FieldResource::collection($fields);
    }

    /**
     * Данные для формы создания нового поля
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json([
            'types' => FieldTypeResource::collection(FieldType::cases()),
        ]);
    }

    /**
     * Создание нового поля
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Fields\FieldResource
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ["required", "string", "max:50"],
            'type' => ["required", new Enum(FieldType::class)],
            'options.*' => ["required_if:type," . FieldType::valuesIsOptions()]
        ]);

        $data['user_id'] = $request->user()->id;
        $data['fieldable'] = $request->get('fieldable') ?: "leads";

        if (!empty($data['options'])) {
            $data['attributes']['options'] = $data['options'];
            unset($data['options']);
        }

        abort_if(!in_array($data['fieldable'], ["leads"]), 400, "Ошибка группы полей");

        return new FieldResource(
            $this->service->create($data)
        );
    }

    /**
     * Данные для формы редактирования поля
     * 
     * @param \App\Models\Field $field
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Field $field)
    {
        return response()->json([
            'field' => new FieldResource($field),
            'types' => FieldTypeResource::collection(FieldType::cases()),
        ]);
    }

    /**
     * Обновление поля
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Field $field
     * @return \App\Http\Resources\Fields\FieldResource
     */
    public function update(Request $request, Field $field)
    {
        $data = $request->validate([
            'title' => ["required", "string", "max:50"],
            'type' => ["required", new Enum(FieldType::class)],
            'options.*' => ["required_if:type," . FieldType::valuesIsOptions()]
        ]);

        return new FieldResource(
            $this->service->update($field, $data)
        );
    }
}
