<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use App\Services\ConvertService\ConvertServiceContract;
use Illuminate\Http\Resources\Json\JsonResource;


class CurrencyHistory extends JsonResource
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
            'rate' => $request->has('base_currency_id') ?
                $this->convert_service->convertById(
                    $this->rate,
                    (int)$request->get('base_currency_id'),
                    $this->currency->nominal,
                    Carbon::createFromFormat('Y-m-d', $request->get('date', now()->format('Y-m-d')))->timestamp
                ) : $this->rate,
            'currency_id' => $this->currency_id,
            'date' => $this->sync_date,
        ];
    }
}
