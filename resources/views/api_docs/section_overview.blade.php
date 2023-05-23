<div id="i-overview">
    <h3 class="h3">Overview</h3>
    <label>Welcome to the Vitruvian Shield API.</label>

    <label class="mt-2">This service allows you to retrieve your patients' raw biometric data so you can use it in your research. You can request data in bulk, individually or from a defined group of patients.</label>

    <label>The base route for this API is:</label>

    @component('api_docs.box_code')
        @slot('text')
            https://www.vitruvianshield.com/api/v1/
        @endslot
    @endcomponent

    <label>Please keep in mind that due to the nature of the API, security and data anonimization are primary concerns. As such, your requests won't be accepted if any of the request fields fails to meet any of the expectations. You must make sure that all information you send to the API is as expected, and meets the requirements.</label>
    <label>For example, if you request data about a group of patients, and among them is a single patient that does not exist (either because you don't have access to his data anymore or because you didn't identify him correctly), your whole request will be aborted.</label>

    @component('api_docs.box_info')
        @slot('icon') <i class="fas fa-info"></i> @endslot
        @slot('text')
            <label>All requests must be complete and must always meet every single expectation without exception. Else, they will be denied.</label>
        @endslot
    @endcomponent

    <label>In this documentation, all API calls are presented with the following format:</label>

    @component('api_docs.box_request')
        @slot('method') TYPE @endslot
        @slot('route')
            api endpoint
        @endslot
        @slot('expected')
            field_a: description<br>
            field_b: description<br>
            ...
        @endslot
        @slot('returned')
            response_field_a: description<br>
            response_field_b: description<br>
            ...
        @endslot
    @endcomponent

    <label>The Vitruvian Shield API communicates in JSON format. It returns responses in JSON format and expects requests to be in that same format as well. For that reason, it is recommended that you include a mention to your formatting in your requests' headers.<br>Usually something such as this, depending on what you are using:</label>

    @component('api_docs.box_code')
        @slot('text')
            accept: application/json<br>
            content-type: application/json<br>
        @endslot
    @endcomponent

</div>

<div id="i-access" class="mt-4">
    <h5 class="h5">API Access</h5>
    <label>To use the API, every single request must send your username and personal API key in its headers, named "username" and "key" respectively.</label>
    <label>Here is a simple example on how you might implement your Vitruvian Shield API requests in PHP:</label>

    @component('api_docs.box_code')
        @slot('text')
            $url = "https://www.vitruvianshield.com/api/v1/patients";<br><br>

            $curl = curl_init();<br><br>

            curl_setopt_array($curl, array(<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_URL => $url,<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_RETURNTRANSFER => true,<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_HTTPHEADER => array(<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"username: <label class="vtext-pop mb-0">YOUR_USERNAME</label>",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"key: <label class="vtext-pop mb-0">YOUR_API_KEY</label>"<br>
            &nbsp;&nbsp;&nbsp;&nbsp;),<br>
            ));<br><br>

            $response = json_decode(curl_exec($curl));<br>
            $err = json_decode(curl_error($curl)); // errors<br>
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);<br><br>

            curl_close($curl);

        @endslot
    @endcomponent

</div>

<div id="i-anonymization" class="mt-4">
    <h5 class="h5">Patient Data</h5>
    <label>Being an API that allows you to access patient medical data, <u>all data is anonymized</u>.</label>
    <label>As such, all patient data must be requested using patient codes. These patient codes must always be included when you request patient data.</label>
    <label>If you want to know who a specific patient really is, you'll have to ask him personally, which requires his explicit concent. All patients have their own code stated in their mobile application, which only they may access.</label>

    @component('api_docs.box_info')
        @slot('icon') <i class="fas fa-info"></i> @endslot
        @slot('text')
            <label>Use patient codes to request data from patients.</label>
        @endslot
    @endcomponent

    <label>You'll only be able to access patient data from your own patients or from patients that are shared with you through team projects.</label>

    @component('api_docs.box_info')
        @slot('icon') <i class="fas fa-info"></i> @endslot
        @slot('text')
            <label>To access data from a patient, that patient must be either directly associated with you or shared with you through at least one team project</label>
        @endslot
    @endcomponent

</div>

<div id="i-example" class="mt-4">
    <h5 class="h5">Usage Example</h5>
    <label>Here we present a complete example written in PHP on how you can request the health profile for three of your patients.</label>
    <label>First you'll need to request a list of your patients using one of the patient consultation routes. This will return a response in JSON format with the codes of the patients that are directly connected to you.</label>

    @component('api_docs.box_code')
        @slot('text')
            $url = "https://www.vitruvianshield.com/api/v1/patients";<br><br>

            $curl = curl_init();<br><br>

            curl_setopt_array($curl, array(<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_URL => $url,<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_RETURNTRANSFER => true,<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_HTTPHEADER => array(<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"accept: application/json",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content-type: application/json",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"username: <label class="vtext-pop mb-0">YOUR_USERNAME</label>",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"key: <label class="vtext-pop mb-0">YOUR_API_KEY</label>"<br>
            &nbsp;&nbsp;&nbsp;&nbsp;),<br>
            ));<br><br>

            $response = json_decode(curl_exec($curl));<br>
            $err = json_decode(curl_error($curl)); // errors<br>
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);<br><br>

            curl_close($curl);

        @endslot
    @endcomponent

    <label>The returned response should contain an array of patient codes.</label>

    @component('api_docs.box_code')
        @slot('text')
            [patients] => ["<label class="vtext-pop mb-0">FIRST_PATIENT_CODE</label>", "<label class="vtext-pop mb-0">SECOND_PATIENT_CODE</label>", "<label class="vtext-pop mb-0">THIRD_PATIENT_CODE</label>", "<label class="vtext-pop mb-0">FOURTH_PATIENT_CODE</label>", ...]
        @endslot
    @endcomponent

    <label>Then you may use those very same patient codes to request data about their health profiles by including them in your request's body "patients" field.</label>

    @component('api_docs.box_code')
        @slot('text')
            $url = "https://www.vitruvianshield.com/api/v1/data/profile";<br><br>

            $curl = curl_init();<br><br>

            $fields = '{"patients":[<br>
            &nbsp;&nbsp;&nbsp;&nbsp;"<label class="vtext-pop mb-0">FIRST_PATIENT_CODE</label>",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;"<label class="vtext-pop mb-0">SECOND_PATIENT_CODE</label>",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;"<label class="vtext-pop mb-0">THIRD_PATIENT_CODE</label>"<br>
            ]}';<br><br>

            curl_setopt_array($curl, array(<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_URL => $url,<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_RETURNTRANSFER => true,<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_HTTPHEADER => array(<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"accept: application/json",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"content-type: application/json",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"username: <label class="vtext-pop mb-0">YOUR_USERNAME</label>",<br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"key: <label class="vtext-pop mb-0">YOUR_API_KEY</label>"<br>
            &nbsp;&nbsp;&nbsp;&nbsp;),<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_POST => 1,<br>
            &nbsp;&nbsp;&nbsp;&nbsp;CURLOPT_POSTFIELDS => $fields,<br>
            ));<br><br>

            $response = json_decode(curl_exec($curl));<br>
            $err = json_decode(curl_error($curl)); // errors<br>
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);<br><br>

            curl_close($curl);

        @endslot
    @endcomponent

    <label>You will receive a response with all of the requested patients' health profiles.</label>

    @component('api_docs.box_code')
        @slot('text')
        [<br>
        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"code": "<label class="vtext-pop mb-0">FIRST_PATIENT_CODE</label>",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"gender": "female",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"date_of_birth": "15/01/1970",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"country": "unspecified",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"weight_kg": "62",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"blood_type": "A+",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"diagnosed_diseases": "unspecified",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"other_conditions": "unspecified"<br>
        &nbsp;&nbsp;&nbsp;&nbsp;},<br>
        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"code": "<label class="vtext-pop mb-0">SECOND_PATIENT_CODE</label>",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"gender": "male",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...<br>
        &nbsp;&nbsp;&nbsp;&nbsp;},<br>
        &nbsp;&nbsp;&nbsp;&nbsp;{<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"code": "<label class="vtext-pop mb-0">THIRD_PATIENT_CODE</label>",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"gender": "female",<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...<br>
        &nbsp;&nbsp;&nbsp;&nbsp;}<br>
        ]
        @endslot
    @endcomponent

</div>