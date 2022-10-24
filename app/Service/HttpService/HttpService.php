<?php

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class HttpService
{

    private string $api_key;
    private \Symfony\Component\HttpClient\ScopingHttpClient $client;

//    const API_URL = 'https://imdb-api.com/fr/API/Search/';

// https://api.themoviedb.org/3/search/multi?api_key=f8dd28041079edd365311590712b3dfc&language=fr-FR&query=teen%20wolf&page=1&include_adult=true

    const API_URL = 'https://api.themoviedb.org/3/';
    const METHODS = ['get', 'post', 'put', 'patch', 'delete'];

    /**
     * @param string $api_key
     * @throws Exception
     */
    public function __construct(string $api_key)
    {
        $this->api_key = $api_key;

        if($this->api_key !== null) {
            $cli = \Symfony\Component\HttpClient\HttpClient::create([
                'max_redirects' => 5,
                "verify_peer" => false,
                "verify_host" => false,
            ]);
            $this->client = new \Symfony\Component\HttpClient\ScopingHttpClient($cli, []);

        } else {
            throw new \Exception('An ApiKey token is required to connect to the IMDB-API.');
        }
    }

    /**
     * Search query
     *
     * @param string $toSearch
     * @param string $type
     * @param int|string $page
     * @return HttpResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function search(string $toSearch, string $type = "multi", int|string $page = 1): HttpResponse
    {
        $response = new HttpResponse();

        $req = $this->client->request(
            'GET',
            self::API_URL . "search/{$type}?api_key={$this->api_key}&language=fr-FR&query={$toSearch}&page={$page}&include_adult=true",
            []
        );

        return $this->fillResponse($req);
    }

    /**
     * Find details query
     *
     * @param string $id
     * @param string $type
     * @return HttpResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function find(string $id, string $type = "multi"): HttpResponse
    {
        $response = new HttpResponse();

        $req = $this->client->request(
            'GET',
            self::API_URL . "{$type}/{$id}?api_key={$this->api_key}&language=fr-FR",
            []
        );

        return $this->fillResponse($req);
    }

    /**
     * Find credits (crew/acting)
     *
     * @param string $id
     * @param string $type
     * @return HttpResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function credits(string $id, string $type = "tv"): HttpResponse
    {
        $response = new HttpResponse();

        $req = $this->client->request(
            'GET',
            self::API_URL . "{$type}/{$id}/credits?api_key={$this->api_key}&language=fr-FR",
            []
        );

        return $this->fillResponse($req);
    }

    /**
     * Retrieve all images stored in TMDB
     *
     * @param string $id
     * @param string $type
     * @return HttpResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function images(string $id, string $type = "tv"): HttpResponse
    {
        $response = new HttpResponse();

        $req = $this->client->request(
            'GET',
            self::API_URL . "{$type}/{$id}/images?api_key={$this->api_key}",
            []
        );

        return $this->fillResponse($req);
    }


    /**
     * Create an HttpResponse and fill it with all the data collected on the HttpClient Request.
     *
     * @param \Symfony\Contracts\HttpClient\ResponseInterface $request
     * @return HttpResponse
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function fillResponse(\Symfony\Contracts\HttpClient\ResponseInterface $request): HttpResponse
    {
        $response = new HttpResponse();
        $response->setCode($request->getStatusCode());

        if (str_starts_with(strval($response->getCode()), '2')) {
            $response->setError(false);
            $response->setHeader($request->getHeaders());
            $response->setContent($request->getContent());
            $response->setData(json_decode($request->getContent()));
        } else {
            $response->setError(true);
            if ($response->getCode() == 404) $response->setErrorMessage("404 Not found.");
            if ($response->getCode() == 403) $response->setErrorMessage("403 Forbidden.");
            if ($response->getCode() == 401) $response->setErrorMessage("403 Unauthorized.");
            if ($response->getCode() == 400) $response->setErrorMessage("400 Bad request.");
        }
        $response->setInfo($request->getInfo());

        return $response;
    }

    /**
     * Check if HTTP method used is in the allowed list.
     *
     * @param string $methodtocheck
     * @return bool
     */
    public function checkMethods(string $methodtocheck): bool
    {
        return in_array(strtolower($methodtocheck), self::METHODS, true);
    }


}