<?php

namespace App\Services\CurrencyService\DataProviders;

use App\Services\CurrencyService\CurrencyServiceDataProviderContract;
use App\Services\CurrencyService\DTO\Currencies;
use App\Services\CurrencyService\DTO\Currency;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use App\Services\CurrencyService\Traits\ConfigurableDataProvider;

class CBR implements CurrencyServiceDataProviderContract
{
    use ConfigurableDataProvider;

    /**
     * @var string
     */
    protected string $source_url;

    /**
     * @var string
     */
    protected string $base_currency;

    public function fetchData(): ?Currencies
    {

        $raw_data = $this->requestDataRaw();

        if (null === $raw_data) {
            return null;
        }

        $body_xml = $raw_data->getBody()->getContents();
        $response_array = $this->convertResponseToArray($body_xml);

        if (0 === count($response_array)) {
            return null;
        }

        $collection = new Currencies();

        foreach ($response_array as $item) {
            $collection->addCurrency(
                (new Currency())
                    ->setCharCode($item['CharCode'])
                    ->setName($item['Name'])
                    ->setNominal($item['Nominal'])
                    ->setValue(floatval($item['Value'])
                    )
            );
        }

        return $collection;
    }

    private function convertResponseToArray(string $raw_response): array
    {
        $body_xml_document = simplexml_load_string($raw_response);

        $items = $body_xml_document->xpath('//ValCurs/Valute');

        $result = [];

        foreach ($items as $el) {
            $result[] = [
                'NumCode' => (string)$el->NumCode ?? null,
                'CharCode' => (string)$el->CharCode ?? null,
                'Nominal' => (string)$el->Nominal ?? null,
                'Name' => (string)$el->Name ?? null,
                'Value' => (string)$el->Value ?? null,
            ];
        }

        return $result;
    }

    private function requestDataRaw(): ?\Psr\Http\Message\ResponseInterface
    {
        try {
            $http_client = new Client();

            return $http_client->get($this->source_url);
        } catch (GuzzleException $exception) {
            Log::error("Exception happened when requestion CBR data", [
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }
}
