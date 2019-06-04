<?php
declare(strict_types=1);

namespace Smile\GdprDump\Config\Validator;

interface ValidationResultInterface
{
    /**
     * Check whether the validation status.
     *
     * @return bool
     */
    public function isValid(): bool;

    /**
     * Set the validation status.
     *
     * @param bool $valid
     * @return ValidationResultInterface
     */
    public function setValid(bool $valid): ValidationResultInterface;

    /**
     * Get the validation messages.
     *
     * @return string[]
     */
    public function getMessages(): array;

    /**
     * Set the validation messages.
     *
     * @param string[] $messages
     * @return ValidationResultInterface
     */
    public function setMessages(array $messages): ValidationResultInterface;
}
