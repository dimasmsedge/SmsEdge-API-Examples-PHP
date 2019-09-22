<?php

include "Validation.php";

class SmsEdgeApi
{
    // =========================== Main ===================================================================== //

    public $api_key;
    public $endpoint;

    public function __construct($api_key, $endpoint = 'https://api.smsedge.io/v1/')
    {
        $this->api_key = $api_key;
        $this->endpoint = $endpoint;
    }

    /**
     * Main function of sending curl request.
     *
     * @param $path
     * @param array $fields
     * @return bool|string
     */
    private function _makeRequest($path, array $fields = [])
    {
        // Api Key set.
        $fields['api_key'] = $this->api_key;

        // Prepare new curl resource
        $ch = curl_init($this->endpoint . $path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        // Submit the POST request
        $result = curl_exec($ch);

        // Close CURL session handle
        curl_close($ch);

        // Returns callback form CURL request.
        return $result;
    }


    // =========================== References ================================================================== //

    /**
     * This function returns all available API functions.
     *
     * @return bool|string
     */
    public function getFunctions(){
        return self::_makeRequest('references/functions/');
    }

    /**
     * This function returns all HTTP response status codes.
     *
     * @return bool|string
     */
    public function getHttpStatuses(){
        return self::_makeRequest('references/statuses/');
    }

    /**
     * This function returns list of countries.
     *
     * @return bool|string
     */
    public function getCountries(){
        return self::_makeRequest('references/countries/');
    }


    // =========================== SMS ===================================================================== //

    /**
     * Send a single SMS message.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function sendSingleSms($fields)
    {
        $validation = new Validation;
        $validation->validate([
            'from' => 'required|string',
            'to' => 'required|numeric|max:64',
            'text' => 'required|string',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'country_id' => 'nullable|numeric|max:32',
            'reference' => 'nullable|string',
            'shorten_url' => 'nullable|boolean',
            'list_id' => 'nullable|numeric|max:32',
            'transactional' => 'nullable|numeric|max:32',
            'preferred_route_id' => 'nullable|numeric|max:32',
            'delay' => 'nullable|numeric|max:32'
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('sms/send-single/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Send SMS messages to all good numbers in a list.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function sendList($fields)
    {
        $validation = new Validation;
        $validation->validate([
            'list_id' => 'required|numeric|max:32',
            'from' => 'required|string',
            'text' => 'required|string',
            'shorten_url' => 'nullable|boolean',
            'preferred_route_id' => 'nullable|numeric|max:32',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('sms/send-list/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Get information about sent SMS messages.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function getSmsInfo($fields)
    {
        $validation = new Validation;
        $validation->validate([
            'ids' => 'required|string',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('sms/get/', $fields);
        }
        $validation->showErrors();
    }


    // =========================== List Of Numbers ================================================================= //

    /**
     * Creating A new list.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function createList($fields)
    {
        $validation = new Validation;
        $validation->validate([
            'name' => 'required|string',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('lists/create/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Deleting an existing list.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function deleteList($fields)
    {
        $validation = new Validation;
        $validation->validate([
            'id' => 'required|numeric',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('lists/delete/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Get all info about a list, including sending stats and numbers segmentation.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function getListInfo($fields)
    {
        $validation = new Validation;
        $validation->validate([
            'id' => 'required|numeric',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('lists/info/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Get all the lists that user created, with information about stored numbers.
     *
     * @param $fields
     * @return bool|string
     */
    public function getAllLists()
    {
        return self::_makeRequest('lists/getall/');
    }


    // =========================== Phone Numbers ================================================================== //

    /**
     * Create a new contact to a list.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function createNumber($fields)
    {
        $validation = new Validation;
        $validation->validate([
            'number' => 'required|string',
            'list_id' => 'required|numeric|max:32',
            'country_id' => 'nullable|numeric|max:32',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('numbers/create/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Delete a record (contact) from an existing list.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function deleteNumber($fields)
    {
        $validation = new Validation;
        $validation->validate([
            'ids' => 'required|string',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('numbers/delete/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Get extended information about numbers.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function getNumbers($fields = [])
    {
        $validation = new Validation;
        $validation->validate([
            'list_id' => 'nullable|numeric|max:32',
            'ids' => 'nullable|string',
            'limit' => 'nullable|numeric|max:32',
            'offset' => 'nullable|numeric|max:32'
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('numbers/get/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Get list of unsubscribed numbers.
     *
     * @return bool|string
     */
    public function getUnsubscribers()
    {
        return self::_makeRequest('numbers/unsubscribers/');
    }


    // =========================== Routes ====================================================================== //

    /**
     * Get all available Routes with prices for different countries.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function getRoutes($fields = []){
        $validation = new Validation;
        $validation->validate([
            'country_id' => 'nullable|numeric|max:32',
            'transactional' => 'nullable|boolean',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('routes/getall/', $fields);
        }
        $validation->showErrors();
    }


    // =========================== Auxiliary Tools ============================================================= //

    /**
     * Logical verification of number.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function numberSimpleVerify($fields){
        $validation = new Validation;
        $validation->validate([
            'number' => 'required|string',
            'country_id' => 'nullable|numeric|max:32',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('verify/number-simple', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Verifying number by request to Home Location Register.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function numberHlrVerify($fields){
        $validation = new Validation;
        $validation->validate([
            'number' => 'required|string',
            'country_id' => 'nullable|numeric|max:32',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('verify/number-hlr', $fields);
        }
        $validation->showErrors();
    }

    /**
     * Verification of text before sending an SMS.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function textAnalyzing($fields){
        $validation = new Validation;
        $validation->validate([
            'text' => 'required|string',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('text/analyze/', $fields);
        }
        $validation->showErrors();
    }


    // =========================== Reports =================================================================== //

    /**
     * This function returns a report about SMS sending process
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function getSendingReport($fields = []){
        $validation = new Validation;
        $validation->validate([
            'status' => 'nullable|string',
            'date_from' => 'nullable',
            'date_to' => 'nullable',
            'limit' => 'nullable|numeric|max:32',
            'offset' => 'nullable|numeric|max:32'
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('reports/sending/', $fields);
        }
        $validation->showErrors();
    }

    /**
     * This function returns a statistics about SMS sending.
     *
     * @param $fields
     * @return bool|string
     * @throws Exception
     */
    public function getSendingStats($fields){
        $validation = new Validation;
        $validation->validate([
            'country_id' => 'required|numeric|max:32',
            'date_from' => 'required',
            'date_to' => 'required',
            'route_id' => 'nullable|numeric|max:32',
        ], $fields);

        if ($validation->run()) {
            return self::_makeRequest('reports/stats/', $fields);
        }
        $validation->showErrors();
    }


    // =========================== User ======================================================================= //
    /**
     * This functions returns API user details.
     *
     * @return bool|string
     */
    public function getUserDetails(){
        return self::_makeRequest('user/details/');
    }

}