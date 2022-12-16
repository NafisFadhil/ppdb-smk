<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Kolom :attribute harus accepted.',
    'accepted_if' => 'Kolom :attribute harus accepted when :other is :value.',
    'active_url' => 'Kolom :attribute is not valid URL.',
    'after' => 'Kolom :attribute harus date after :date.',
    'after_or_equal' => 'Kolom :attribute harus date after atau sama dengan :date.',
    'alpha' => 'Kolom :attribute must only contain letters.',
    'alpha_dash' => 'Kolom :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'Kolom :attribute must only contain letters and numbers.',
    'array' => 'Kolom :attribute harus an array.',
    'before' => 'Kolom :attribute harus date before :date.',
    'before_or_equal' => 'Kolom :attribute harus date before atau sama dengan :date.',
    'between' => [
        'array' => 'Kolom :attribute must have antara :min and :max items.',
        'file' => 'Kolom :attribute harus antara :min and :max kilobytes.',
        'numeric' => 'Kolom :attribute harus antara :min and :max.',
        'string' => 'Kolom :attribute harus antara :min and :max karakter.',
    ],
    'boolean' => 'Kolom :attribute field harus true atau false.',
    'confirmed' => 'Kolom :attribute confirmation does not match.',
    'current_password' => 'Kolom password is incorrect.',
    'date' => 'Kolom :attribute is not valid date.',
    'date_equals' => 'Kolom :attribute harus date sama dengan :date.',
    'date_format' => 'Kolom :attribute does not match the format :format.',
    'declined' => 'Kolom :attribute harus declined.',
    'declined_if' => 'Kolom :attribute harus declined when :other is :value.',
    'different' => 'Kolom :attribute and :other harus different.',
    'digits' => 'Kolom :attribute harus :digits digits.',
    'digits_between' => 'Kolom :attribute harus antara :min and :max digits.',
    'dimensions' => 'Kolom :attribute has invalid image dimensions.',
    'distinct' => 'Kolom :attribute field has duplicate value.',
    'doesnt_end_with' => 'Kolom :attribute may not end with one of the following: :values.',
    'doesnt_start_with' => 'Kolom :attribute may not start with one of the following: :values.',
    'email' => 'Kolom :attribute harus valid email address.',
    'ends_with' => 'Kolom :attribute must end with one of the following: :values.',
    'enum' => 'Kolom selected :attribute is invalid.',
    'exists' => 'Kolom selected :attribute is invalid.',
    'file' => 'Kolom :attribute harus file.',
    'filled' => 'Kolom :attribute field must have value.',
    'gt' => [
        'array' => 'Kolom :attribute must have more than :value items.',
        'file' => 'Kolom :attribute harus greater than :value kilobytes.',
        'numeric' => 'Kolom :attribute harus greater than :value.',
        'string' => 'Kolom :attribute harus greater than :value karakter.',
    ],
    'gte' => [
        'array' => 'Kolom :attribute must have :value items atau more.',
        'file' => 'Kolom :attribute harus greater than atau sama dengan :value kilobytes.',
        'numeric' => 'Kolom :attribute harus greater than atau sama dengan :value.',
        'string' => 'Kolom :attribute harus greater than atau sama dengan :value karakter.',
    ],
    'image' => 'Kolom :attribute harus an image.',
    'in' => 'Kolom selected :attribute is invalid.',
    'in_array' => 'Kolom :attribute field does not exist in :other.',
    'integer' => 'Kolom :attribute harus an integer.',
    'ip' => 'Kolom :attribute harus valid IP address.',
    'ipv4' => 'Kolom :attribute harus valid IPv4 address.',
    'ipv6' => 'Kolom :attribute harus valid IPv6 address.',
    'json' => 'Kolom :attribute harus valid JSON string.',
    'lt' => [
        'array' => 'Kolom :attribute must have kurang dari :value items.',
        'file' => 'Kolom :attribute harus kurang dari :value kilobytes.',
        'numeric' => 'Kolom :attribute harus kurang dari :value.',
        'string' => 'Kolom :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Kolom :attribute must not have more than :value items.',
        'file' => 'Kolom :attribute harus kurang dari atau sama dengan :value kilobytes.',
        'numeric' => 'Kolom :attribute harus kurang dari atau sama dengan :value.',
        'string' => 'Kolom :attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => 'Kolom :attribute harus valid MAC address.',
    'max' => [
        'array' => 'Kolom :attribute must not have more than :max items.',
        'file' => 'Kolom :attribute harus kurang dari :max kilobytes.',
        'numeric' => 'Kolom :attribute harus kurang dari :max.',
        'string' => 'Kolom :attribute harus kurang dari :max karakter.',
    ],
    'max_digits' => 'Kolom :attribute must not have more than :max digits.',
    'mimes' => 'Kolom :attribute harus file of type: :values.',
    'mimetypes' => 'Kolom :attribute harus file of type: :values.',
    'min' => [
        'array' => 'Kolom :attribute harus lebih dari :min items.',
        'file' => 'Kolom :attribute harus lebih dari :min kilobytes.',
        'numeric' => 'Kolom :attribute harus lebih dari :min.',
        'string' => 'Kolom :attribute harus lebih dari :min karakter.',
    ],
    'min_digits' => 'Kolom :attribute must have setidaknya :min digits.',
    'multiple_of' => 'Kolom :attribute harus multiple of :value.',
    'not_in' => 'Kolom selected :attribute is invalid.',
    'not_regex' => 'Kolom :attribute format is invalid.',
    'numeric' => 'Kolom :attribute harus berupa nomor.',
    'password' => [
        'letters' => 'Kolom :attribute must contain setidaknya one letter.',
        'mixed' => 'Kolom :attribute must contain setidaknya one uppercase and one lowercase letter.',
        'numbers' => 'Kolom :attribute must contain setidaknya one number.',
        'symbols' => 'Kolom :attribute must contain setidaknya one symbol.',
        'uncompromised' => 'Kolom given :attribute has appeared in data leak. Please choose different :attribute.',
    ],
    'present' => 'Kolom :attribute field harus present.',
    'prohibited' => 'Kolom :attribute field is prohibited.',
    'prohibited_if' => 'Kolom :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'Kolom :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'Kolom :attribute field prohibits :other from being present.',
    'regex' => 'Kolom :attribute format is invalid.',
    'required' => 'Kolom :attribute tidak boleh kosong.',
    'required_array_keys' => 'Kolom :attribute field must contain entries for: :values.',
    'required_if' => 'Kolom tidak boleh kosong jika jalur pendaftaran adalah prestasi.',
    // 'required_if' => 'Kolom :attribute field is required when :other is :value.',
    'required_if_accepted' => 'Kolom :attribute field is required when :other is accepted.',
    'required_unless' => 'Kolom :attribute field is required unless :other is in :values.',
    'required_with' => 'Kolom :attribute field is required when :values is present.',
    'required_with_all' => 'Kolom :attribute field is required when :values are present.',
    'required_without' => 'Kolom :attribute field is required when :values is not present.',
    'required_without_all' => 'Kolom :attribute field is required when none of :values are present.',
    'same' => 'Kolom :attribute and :other must match.',
    'size' => [
        'array' => 'Kolom :attribute must contain :size items.',
        'file' => 'Kolom :attribute harus :size kilobytes.',
        'numeric' => 'Kolom :attribute harus :size.',
        'string' => 'Kolom :attribute harus :size karakter.',
    ],
    'starts_with' => 'Kolom :attribute must start with one of the following: :values.',
    'string' => 'Kolom :attribute harus berupa huruf atau text.',
    'timezone' => 'Kolom :attribute harus valid timezone.',
    'unique' => 'Kolom :attribute sudah dipakai.',
    'uploaded' => 'Kolom :attribute failed to upload.',
    'url' => 'Kolom :attribute harus valid URL.',
    'uuid' => 'Kolom :attribute harus valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify specific custom language line for given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
