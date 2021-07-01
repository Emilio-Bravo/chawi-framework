<?php

namespace Core\Support;

class Validator
{

    private string $currentInputKey;

    private array $messages = [];

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
        'required' => '%s is required',
        'email' => 'Enter a valid email address',
        'string' => '%s can just have letters with numbers',
        'number' => '%s can just have numbers',
        'digit' => '%s can just have digits',
        'word' => '%s can just have words',
        'url' => 'Enter a valid URL',
        'max' => '%s musn´t have more than %d characters',
        'min' => '%s must have more than %d characters',
        'fix' => '%s must have %d characters'
    ];

    public function validate(\Core\Http\Request $request, array $data): void
    {
        foreach ($data as $requestKey => $rule_name) {
            $rule_set = explode('|', $rule_name);
            $this->currentInputKey = $requestKey;
            array_map(fn ($rule) => $this->performRuleValidation($rule, $request->input($requestKey)), $rule_set);
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
            $this->cancel(sprintf($this->error_msgs[$rule_name], $this->currentInputKey));
        }
        $this->handleVariableRules($rule_name, $subject);
    }

    private function performCountingRuleValidation(string $rule, string $subject): void
    {
        if ($this->match($rule, 'max:')) {

            strlen($subject) < $this->getLimits($rule) ?: $this->cancel(

                sprintf(
                    $this->error_msgs['max'],
                    $this->currentInputKey,
                    $this->getLimits($rule)
                )

            );
        }

        if ($this->match($rule, 'min:')) {

            strlen($subject) > $this->getLimits($rule) ?: $this->cancel(

                sprintf(
                    $this->error_msgs['min'],
                    $this->currentInputKey,
                    $this->getLimits($rule)
                )

            );
        }

        if ($this->match($rule, 'fix:')) {

            strlen($subject) == $this->getLimits($rule) ?: $this->cancel(

                sprintf(
                    $this->error_msgs['fix'],
                    $this->currentInputKey,
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
