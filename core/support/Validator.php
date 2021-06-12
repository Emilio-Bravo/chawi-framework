<?php

namespace Core\Support;

class Validator
{

    private array $rules = [
        'required' => '/*/',
        'email' => '/[\w\_.@%]+@[\w\d_.@%]+\.[\w\d]/',
        'string' => '/[A-z0-9]/',
        'number' => '/[0-9]/',
        'digit' => '/\d/',
        'word' => '/\w/',
        'url' => '/^(http|https)+:\/\/+([\w\S\d])+\.([\w\d])+?([a-z])+$/',
    ];

    private array $error_msg = [
        'required' => 'This file is required',
        'email' => 'Enter a valid email address',
        'string' => 'Just letters and numbers are allowed',
        'number' => 'Just numbers are allowed',
        'digit' => 'Just digits are allowed',
        'word' => 'Just words are allowed',
        'url' => 'Enter a valid URL'
    ];

    private array $responses = [
        'error' => 'error',
        'success' => 'success'
    ];

   public function validate(array $data): void
    {
        foreach ($data as $value => $rule_name) {
            $rule_set = explode('|', $rule_name);
            array_map(fn ($rule) => $this->extract_rule($rule, $value), $rule_set);
        }
    }
    
    private function extract_rule(string $rule_name, mixed $subject_data): void
    {
        $this->performRuleValidation($rule_name, $subject_data);
    }

    private function performRuleValidation(string $rule_name, mixed $subject): void
    {
        if (!preg_match($this->rules[$rule_name], $subject)) {
            exit(\Core\Http\Response::cancel()->with($this->responses['error'], $this->error_msg[$rule_name]));
        }
    }
}
