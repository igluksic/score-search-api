<?php

namespace App\JsonApi;

class MicroJsonApi
{
    const JSONAPI_ACCEPT_HEADER = 'application/vnd.api+json';
    const MEDIA_TYPE_QUERY = 'q=';
    const RESPONSE_NOT_ACCEPTABLE = 406;
    const RESPONSE_UNSUPPORTED_MEDIA_TYPE = 415;
    const RESPONSE_OK = 200;

    protected $errors = [];

    public function checkHeaders($request)
    {
        $acceptHeaders = str_replace(' ', '', $request->header('accept'));
        foreach (explode(',', $acceptHeaders) as $acceptHeader) {
            if (stristr($acceptHeader, self::JSONAPI_ACCEPT_HEADER) == null) {
                $this->addError('Method not acceptable');
                return self::RESPONSE_NOT_ACCEPTABLE;
            }
        }
        if (strstr($acceptHeaders, self::MEDIA_TYPE_QUERY) != null ) {
            $this->addError('Unsupported media type');
            return self::RESPONSE_UNSUPPORTED_MEDIA_TYPE;
        }
        return self::RESPONSE_OK;
    }

    public function addError($text)
    {
        $this->errors[] = $text;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function formatResponse ($attributes, $type, $id, $errors = [])
    {
        if (count($errors) == 0) {
            $formatMinimal = [
                'data' => [
                    'type' => $type,
                    'id' => $id,
                    'attributes' => $attributes
                ]
            ];

        } else {
            $formatMinimal = [
                'errors' => $errors
            ];
        }
        return $formatMinimal;
    }
}