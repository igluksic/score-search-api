<?php
namespace App\Score\DataReaders;
use App\Score\Interfaces\DataReaderInterface;
use GuzzleHttp\Client;
use App\Models\Score;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

class GitHubIssueReader extends BaseIssueReader implements DataReaderInterface
{
    public $client;

    public function __construct(string $query, Score $score)
    {
        parent::__construct($query, $score);
        $this->client = new Client();
    }

    public function readEndpoint(string $actualQuery)
    {
        $uri = config('endpoints.apiEndpoint') . '?q=' . urlencode($actualQuery);

        try {
            $contents = $this->client->request(
                'GET',
                $uri,
                ['headers' => [
                    'Accept' => 'application/vnd.github.symmetra-preview+json'
                ]]
            )->getBody()->getContents();
            return $contents;
        } catch (ClientException $e) {
            $this->setError('Clientexception, cant read endpoint.');
            $this->setStatusCode(500);
            return 0;
        } catch (RequestException $e) {
            $this->setError('Requestexception, cant read endpoint.');
            $this->setStatusCode(500);
            return 0;
        }
    }

    public function getPositiveNumber()
    {
        if (!is_null($this->score->positive_results)) {
            return $this->score->positive_results;
        }
        $endpointData = json_decode($this->readEndpoint($this->query . ' ' . self::POSITIVE_IDENTIFICATION_SUFFIX), true);
        if ($endpointData != 0) {
            return $this->processScore('positive_results', $endpointData['total_count']);
        } else {
            return 0;
        }
    }

    public function getNegativeNumber()
    {
        if (!is_null($this->score->negative_results)) {
            return $this->score->negative_results;
        }
        $endpointData = json_decode($this->readEndpoint($this->query . ' ' . self::NEGATIVE_IDENTIFICATION_SUFFIX), true);
        if ($endpointData != 0) {
            return $this->processScore('negative_results', $endpointData['total_count']);
        } else {
           return 0;
        }
    }

    public function getTotalNumber()
    {
        return $this->getNegativeNumber() + $this->getPositiveNumber();
    }

}