<?php

namespace App\Services\Google\PageSpeedOnline;

use App\Enums\CategoryEnum;
use App\Infra\DataObjects\ErrorResponse;
use App\Infra\DataObjects\PageSpeedService\PageSpeedServiceSuccessResponseData;
use App\Infra\DataObjects\PageSpeedService\RunBenchmarkInputData;
use App\Infra\Interfaces\PageSpeedServiceInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\RequestOptions;

class PageSpeedOnlineService implements PageSpeedServiceInterface
{
    private const API_BASE_URL = "https://www.googleapis.com/pagespeedonline/";

    public function __construct(
        private readonly string $apiKey,
        private readonly int    $timeoutInS = 5 * 60,
    ) {}

    /**
     * @inheritDoc
     */
    public function runBenchmark(RunBenchmarkInputData $input): PageSpeedServiceSuccessResponseData|ErrorResponse {
        try {
            $client = new Client([
                'base_uri' => self::API_BASE_URL,
                'verify' => false,
            ]);

            $response = $client->get("v5/runPagespeed", [
                RequestOptions::QUERY => urldecode(http_build_query([
                    'key' => $this->apiKey,
                    'url' => $input->getUrl()->value(),
                    'strategy' => $input->getStrategy()->value,
                    'category' => implode('&category=', CategoryEnum::getFlattenValues($input->getCategories()))
                ])),
                RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                ],
                RequestOptions::TIMEOUT => $this->timeoutInS,
            ]);

            $parsedResponseData = json_decode($response->getBody()->getContents(), true, 1024);

            /**
             * @var ['CategoryEnumValue' => 0.3, 'CategoryEnumValue' => 2.8]
             */
            $insightsScores = [];

            foreach ($input->getCategories() as $category) {
                if ($category === CategoryEnum::PWA) {
                    continue;
                }

                $categoryName = str_replace('_', '-', strtolower($category->value));

                $insightsScores[$category->value] = $parsedResponseData['lighthouseResult']['categories'][$categoryName]['score'];
            }

            return new PageSpeedServiceSuccessResponseData(
                $input,
                $insightsScores,
            );
        } catch (RequestException $e) {
            $errorMsg = '';
            $code = 1901;

            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody()->getContents(), true);

                if (
                    array_key_exists('error', $response)
                    && array_key_exists('message', $response['error'])
                    && str_contains($response['error']['message'], 'FAILED_DOCUMENT_REQUEST')
                ) {
                    $code = 1910;
                    $errorMsg .= "Page URL not found on internet. Try using another webpage.";
                } else {
                    $statusCode = $e->getResponse()->getStatusCode();
                    if ($statusCode >=400 && $statusCode < 500) {
                        $errorMsg = "Failed to run Metrics. Try again, or change the web page, it probably does not exists or returned an error.";
                    } else {
                        $errorMsg = "Failed to run Metrics. StatusCode<{$e->getResponse()->getStatusCode()}, {$e->getResponse()->getReasonPhrase()}>";
                    }
                }
            } else {
                $errorMsg .= $e->getMessage();
            }

            return new ErrorResponse($code, $errorMsg);
        } catch (GuzzleException|Exception $e) {
            return new ErrorResponse(1902, 'Internal Error: '.$e->getMessage());
        }
    }
}
