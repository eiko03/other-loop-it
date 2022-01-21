<?php

namespace App\Http\FormValidations;

use Illuminate\Support\Facades\Validator;

abstract class FormValidation
{
    protected $request;
    protected $extraData;
    protected $defaultMessages;
    protected $validator;

    /**
     * Stores the request which can be used for making dynamic rules or messages or attributes
     * @param [\Illuminate\Http\Request] $request
     * @param array $extraData
     */
    public function __construct($request, $extraData = [])
    {
        $this->request = $request;
        $this->extraData = $extraData;
        $this->setDefaultMessages();
    }

    /**
     * Every validation must have some rules.
     * @return array [Array]
     */
    abstract public function rules(): array;

    private function setDefaultMessages()
    {
        $this->defaultMessages = config('validation')['messages'];
    }

    /**
     * Some validation may have custom messages
     * @return array [Array]
     */
    public function messages(): array
    {
        return [];
    }

    /**
     * Some validation may have custom attributes
     * @return array [Array]
     */
    public function attributes(): array
    {
        return [];
    }

    /**
     * Form Data or any data which are to be validated are required for validation
     * @return mixed [Array]
     */
    public function getData()
    {
        return $this->request->all();
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public function fails(): bool
    {
        $this->validator = Validator::make($this->getData(), $this->rules(), $this->messages() + $this->defaultMessages, $this->attributes());

        return $this->validator->fails();
    }
}
