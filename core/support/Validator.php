<?php

namespace Core\Support;

class Validator
{

    private array $rules = [
        'required' => '/.+/',
        'email' => '/[\w\_.@%]+@[\w\d_.@%]+\.[\w\d]/',
        'string' => '/[A-z]+[0-9]*/',
        'number' => '/[0-9]/',
        'digit' => '/\d/',
        'word' => '/\w/',
        'url' => '/^(http|https)+:\/\/+([\w\S\d])+\.([\w\d])+?([a-z])+$/',
        'letters' => '/[A-z]/'
    ];

    private array $counting_rules = [
        'min' => 'min:[0-9]+',
        'max' => 'max:[0-9]+',
        'fix' => 'fix:[0-9]+'
    ];

    private array $error_msgs = [
        'required' => 'The fields are required',
        'email' => 'Enter a valid email address',
        'string' => 'Just letters with numbers are allowed',
        'number' => 'Just numbers are allowed',
        'digit' => 'Just digits are allowed',
        'word' => 'Just words are allowed',
        'url' => 'Enter a valid URL',
        'max' => 'Data musn´t have more than %d characters',
        'min' => 'Data must have more than %d characters',
        'fix' => 'Data must have %d characters'
    ];

    public function validate(array $data): void
    {
        foreach ($data as $value => $rule_name) {
            $rule_set = explode('|', $rule_name);
            array_map(fn ($rule) => $this->performRuleValidation($rule, $value), $rule_set);
        }
    }

    private function handleVariableRules(string $rule, string $subject)
    {
        $rule_set = \Core\Support\Formating\Str::regex(implode('|', $this->counting_rules));

        if (preg_match($rule_set, $rule)) {
            $this->performCountingRuleValidation($rule, $subject);
        }
    }

    private function performRuleValidation(string $rule_name, mixed $subject): void
    {
        if (key_exists($rule_name, $this->rules) && !preg_match($this->rules[$rule_name], $subject)) {
            $this->cancel($this->error_msgs[$rule_name]);
        }
        $this->handleVariableRules($rule_name, $subject);
    }

    private function performCountingRuleValidation(string $rule, string $subject): void
    {
        if ($this->match($rule, 'max:')) {

            strlen($subject) < $this->getLimits($rule) ?: $this->cancel(

                sprintf(
                    $this->error_msgs['max'],
                    $this->getLimits($rule)
                )

            );
        }

        if ($this->match($rule, 'min:')) {

            strlen($subject) > $this->getLimits($rule) ?: $this->cancel(

                sprintf(
                    $this->error_msgs['min'],
                    $this->getLimits($rule)
                )

            );
        }

        if ($this->match($rule, 'fix:')) {

            strlen($subject) == $this->getLimits($rule) ?: $this->cancel(

                sprintf(
                    $this->error_msgs['fix'],
                    $this->getLimits($rule)
                )

            );
        }
    }

    private function getLimits($rule): int
    {
        return explode(':', $rule)[1];
    }

    private function match(string $subject, string $search): bool
    {
        return preg_match(\Core\Support\Formating\Str::regex($search), $subject);
    }

    private function cancel($msg): void
    {
        exit((string) new \Core\Http\ResponseComplements\redirectResponse('back', [
            'error' => $msg
        ]));
    }
}
