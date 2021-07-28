<?php

namespace Core\Support\Validation;

use Core\Config\Support\interactsWithValidatorConfig;
use Core\Support\Formating\MsgParser;

class Validator
{

    use interactsWithValidatorConfig;

    /**
     * The current request input key
     * 
     * @var string
     */
    protected string $currentInputKey;

    /**
     * The current string to evaluate
     * 
     * @var string
     */
    protected string $currentSubject;

    /**
     * The selected rule
     * 
     * @var string
     */
    protected string $currentRule;

    /**
     * The current error
     * 
     * @var string|null
     */
    protected ?string $currentError = null;

    /**
     * Wether the validation should be outputed 
     * as a JSON response
     * 
     * @var bool
     */
    protected bool $isJson = false;

    /**
     * The validator config
     * 
     * @var object
     */
    protected object $config;

    /**
     * The validation error bag
     * 
     * @var Core\Support\Validation\ErrorBag
     */
    protected ErrorBag $errors;

    /**
     * Create a new validator
     */
    public function __construct()
    {
        $this->config = $this->getValidatorConfig();
        $this->errors = new ErrorBag;
    }

    /**
     * Output the results
     */
    public function __destruct()
    {
        if ($this->isJson && !empty($this->errors)) $this->customCancel(

            new \Core\Http\Response(
                [
                    'status' => 'error',
                    'errors' => $this->errors->get()
                ],
                500
            )

        );

        if (!empty($this->errors->get())) $this->cancel();
    }

    /**
     * Perform a rule validation
     * 
     * @param Core\Http\Request $request
     * @param array $data ['name' => 'required|string|min:2|max:20']
     * @return self
     */
    public function validate(\Core\Http\Request $request, array $data): self
    {

        foreach ($data as $requestKey => $rule_name) {

            $rule_set = explode('|', $rule_name);

            $this->currentInputKey = $requestKey;

            foreach ($rule_set as $rule) {
                $this->currentRule = $rule;
                $this->performRuleValidation($request->input($requestKey));
            }
        }

        return $this;
    }

    /**
     * Handles variables whose value can vary
     * 
     * @return void
     */
    protected function handleVariableRules(): void
    {
        $rule_set = \Core\Support\Formating\Str::regex(implode('|', (array) $this->config->counting_rules));

        if (preg_match($rule_set, $this->currentRule)) {
            $this->performCountingRuleValidation($this->currentSubject);
        }
    }

    /**
     * Performs the rule evaluation and validation
     * 
     * @param mixed $subject
     * @return void
     */
    protected function performRuleValidation(mixed $subject): void
    {
        $this->currentSubject = $subject;

        if (key_exists($this->currentRule, $this->config->rules) && !preg_match($this->config->rules[$this->currentRule], $this->currentSubject)) {

            $this->setError(

                MsgParser::format(
                    $this->config->error_msgs[$this->currentRule],
                    $this->currentInputKey
                )

            );
        }

        $this->handleVariableRules();
    }

    /**
     * Performs the character counting rules 
     * 
     * @return void
     */
    protected function performCountingRuleValidation(): void
    {

        $rule = preg_split('/[0-9\W]/', $this->currentRule)[0];

        $this->setCountingRules();

        if (key_exists($rule, $this->config->counting_rules)) {

            $this->config->counting_rules[$rule] ?: $this->setError(

                MsgParser::format(
                    $this->config->error_msgs[$rule],
                    $this->currentInputKey,
                    $this->getLimits($rule)
                )

            );
        }
    }

    /**
     * Sets the character counting rules functionalities
     * 
     * @return void
     */
    protected function setCountingRules(): void
    {
        $this->config->counting_rules['min'] = strlen($this->currentSubject) > $this->getLimits();
        $this->config->counting_rules['max'] = strlen($this->currentSubject) < $this->getLimits();
        $this->config->counting_rules['fix'] = strlen($this->currentSubject) == $this->getLimits();
    }

    /**
     * Returns the couting rule string length limits
     * 
     * @return int
     */
    protected function getLimits(): int
    {
        return (int) @explode(':', $this->currentRule)[1];
    }

    /**
     * Makes a redirect response
     * 
     * @return void
     */
    protected function cancel(): void
    {
        new \Core\Http\ResponseComplements\redirectResponse(
            'back',
            ['errors' => $this->errors->get()],
            500
        );

        exit;
    }

    /**
     * Performs the given function as a terminating one
     * 
     * @param mixed $content
     * @return void
     */
    protected function customCancel($content): void
    {
        $content;
        exit;
    }

    /**
     * Sets the input errors
     * 
     * @param string $error
     * @return void
     */
    protected function setError(string $error): void
    {
        if (!$this->errors->has($error)) $this->errors->add(
            "{$this->currentInputKey}_error",
            $error
        );
    }

    /**
     * The validation results will be outputed as a JSON response
     * 
     * @return void
     */
    public function asResponse()
    {
        $this->isJson = true;
    }

    /**
     * Get the current request input key
     *
     * @return string
     */
    public function getCurrentInputKey()
    {
        return $this->currentInputKey;
    }

    /**
     * Get the current string to evaluate
     *
     * @return string
     */
    public function getCurrentSubject()
    {
        return $this->currentSubject;
    }

    /**
     * Get the selected rule
     *
     * @return string
     */
    public function getCurrentRule()
    {
        return $this->currentRule;
    }

    /**
     * Get the current error
     *
     * @return string|null
     */
    public function getCurrentError()
    {
        return $this->currentError;
    }

    /**
     * Get wether the validation should be outputed 
     * as a JSON response
     *
     * @return bool
     */
    public function getIsJson(): bool
    {
        return $this->isJson;
    }

    /**
     * Get the validator config
     *
     * @return object
     */
    public function getConfig(): object
    {
        return $this->config;
    }

    /**
     * Get the validation error bag
     *
     * @return Core\Support\Validation\ErrorBag
     */
    public function getErrors(): ErrorBag
    {
        return $this->errors;
    }
}
