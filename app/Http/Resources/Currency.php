<?php

namespace App\Http\Resources;

use App\Services\ConvertService\ConvertServiceContract;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class Currency extends JsonResource
{
    /**
     * @var ConvertServiceContract
     */
    protected $convert_service;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->convert_service = app(ConvertServiceContract::class);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'num_code' => $this->num_code,
            'nominal' => $this->nominal,
            'rate' => $this->whenLoaded('dayData', $request->has('base_currency_id') ?
                $this->convert_service->convertById(
                    $this->dayData->first()->rate ?? $this->createRateNotFoundException(),
                    (int)$request->get('base_currency_id'),
                    $this->nominal,
                    Carbon::createFromFormat('Y-m-d', $request->get('date', now()->format('Y-m-d')))->timestamp
                )
                : optional($this->dayData->first())->rate) ?? 0, // if no data come for today.
            'max' => $this->day_data_max_rate ?? null,
            'min' => $this->day_data_min_rate ?? null,
            'avg' => $this->day_data_avg_rate ?? null,
        ];
    }

    /**
     * @throws \InvalidArgumentException
     */
    private function createRateNotFoundException()
    {
        throw new \InvalidArgumentException("Rate for given date not found.");
    }
}
