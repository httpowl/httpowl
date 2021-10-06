<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class Request extends Base implements Runnable
{

    public function run()
    {
        // If first parameter is empty list collections
        $collectionAction = $this->context->argument('collection:action');
        if (empty($collectionAction)) {
            (new Ls($this->context))->run();

            return ;
        }

        // Get action from first argument or second
        $collectionAction = explode(':', $collectionAction);
        if (!isset($collectionAction[1])) {
            $collectionAction[1] = $this->context->argument('action');
        }

        $collectionContents = $this->getCollectionContent($collectionAction[0]);

        // If action parameter is empty list collection actions
        if (empty($collectionAction[1])) {
            $this->listCollectionActions($collectionContents);

            return ;
        }

        // Check if action exists
        $collectionContent = collect($collectionContents)->where('name', $collectionAction[1])->first();
        if (empty($collectionContent)) {
            $this->context->error('Requested action not found: ' . $collectionAction[1]);
            exit(1);
        }

        //
        $this->makeHttpRequest($collectionContent);
    }

    private function getCollectionContent($collection): array
    {
        $collectionPath = config('owl.base_folder') . "/{$collection}.json";
        if (!File::exists($collectionPath)) {
            $this->context->error('Collection not found: ' . $collection);
            exit(1);
        }

        $collectionContent = json_decode(File::get($collectionPath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->context->error('Collection contains malformed json. Please check this file: ' . $collectionPath);
            exit(1);
        }

        return $collectionContent;
    }

    private function listCollectionActions($collectionContents)
    {
        foreach ($collectionContents as $item) {
            if (isset($item['name'])) {
                $this->context->info($item['name']);
            }
        }
    }

    private function makeHttpRequest($collectionContent)
    {
        // TODO: replace template parameters "{{endpoint}} => https://example..."
        $httpMethod = strtolower($collectionContent['method'] ?? 'GET'); // TODO: check if method is correct
        $url = $collectionContent['url'] ?? null;
        $payload = $collectionContent['payload'] ?? [];
        $headers = $collectionContent['headers'] ?? []; // TODO: merge this with env file headers

        // Make request
        $response = Http::timeout(10) // TODO: get timeout from env file (default is: 10)
            ->withHeaders($headers)
            ->{$httpMethod}($url, $payload);

        $color = new \NunoMaduro\Collision\ConsoleColor();

        // Print http code
        echo sprintf(
            "%s/%s %s %s\n",
            $color->apply('blue', 'HTTP'),
            $color->apply('cyan', $response->getProtocolVersion()),
            $color->apply('cyan', $response->status()),
            $color->apply(
                'yellow',
                \Symfony\Component\HttpFoundation\Response::$statusTexts[$response->status()]
            )
        );

        // Print response headers
        $this->context->comment(str_pad('HEADERS', 40, '=', STR_PAD_BOTH));
        foreach ($response->headers() as $headerKey => $headerValue) {
            echo $headerKey . ': ';
            echo $color->apply('cyan', implode(', ', $headerValue)) . PHP_EOL;
        }

        // Print response body
        $this->context->comment(str_pad('BODY', 40, '=', STR_PAD_BOTH));
        $this->context->info($response->body()); // TODO: if json make it pretty
    }
}
