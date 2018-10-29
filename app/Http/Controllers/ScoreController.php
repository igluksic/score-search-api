<?php

namespace App\Http\Controllers;
use App\Score\ScoreBuilder;
use App\Score\DataReaders\GitHubIssueReader;
use Illuminate\Http\Request;
use App\JsonApi\MicroJsonApi;

class ScoreController extends Controller
{

    public function score($query)
    {
        $processor = (new ScoreBuilder(GitHubIssueReader::class, $query))->getInstance();
        $data = [
            'term' => $query,
            'score' => $processor->getPostiveScore()
        ];
        return response()->json($data, $processor->getReaderStatusCode());
    }

    //TODO: do this properly with some ready made package, this is just minimal req to conform the specifications MUST clauses
    public function v2Score($query)
    {
        $processor = (new ScoreBuilder(GitHubIssueReader::class, $query))->getInstance();
        $data = [
            'term' => $query,
            'score' => $processor->getPostiveScore()
        ];
        $jsonapiFormatedData = (new MicroJsonApi())->formatResponse($data, 'score', $processor->getScore()->id, $processor->getReaderErrors());
        return response()->json($jsonapiFormatedData, $processor->getReaderStatusCode(), ['Content-Type' => 'application/vnd.api+json']);
    }

}
