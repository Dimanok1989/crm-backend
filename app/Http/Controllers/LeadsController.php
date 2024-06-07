<?php

namespace App\Http\Controllers;

use App\Enums\Leads\LeadStatuses;
use App\Http\Resources\Leads\LeadDetailResource;
use App\Http\Resources\Leads\LeadFormResource;
use App\Http\Resources\Leads\LeadResource;
use App\Http\Services\Leads\LeadsService;
use App\Models\Customer;
use App\Models\Lead;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class LeadsController extends Controller
{
    use AuthorizesRequests;

    /**
     * Инициализация контроллера
     * 
     * @param \App\Http\Services\Leads\LeadsService $service
     * @return void
     */
    public function __construct(
        protected LeadsService $service
    ) {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', Lead::class);

        return LeadResource::collection(
            $this->service->list(auth()->user())
        );
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \App\Http\Resources\Leads\CreateLeadResource
     */
    public function create(Request $request)
    {
        $this->authorize('create', Lead::class);

        return new LeadFormResource($request->user());
    }

    /**
     * Создание новой заявки
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Leads\LeadResource
     */
    public function store(Request $request)
    {
        $this->authorize('create', Lead::class);

        $data = $request->validate([
            'status_id' => ["required", new Enum(LeadStatuses::class)],
            'customer_id' => [
                "nullable",
                Rule::exists(Customer::class, 'id')
                    ->where(function ($query) use ($request) {
                        $query->where('user_id', $request->user()->id ?? null);
                    })
            ],
            'name' => ["nullable", "string"],
            'event_start_at' => ["required", "date"],
        ]);

        return new LeadResource(
            $this->service->create([...$data, 'user_id' => $request->user()->id ?? null])
        );
    }

    /**
     * Детальная страница заявки
     * 
     * @param \App\Models\Lead $lead
     * @return \App\Http\Resources\Leads\LeadDetailResource
     */
    public function show(Lead $lead)
    {
        $this->authorize('view', $lead);

        return new LeadDetailResource($lead);
    }

    /**
     * Данные для формы редактирования заявки
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Lead $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, Lead $lead)
    {
        $this->authorize('edit', $lead);

        $response = (new LeadFormResource($request->user()))->toArray($request);
        $response['lead'] = new LeadResource($lead);

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
