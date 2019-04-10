<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Support;


interface BundleInterface
{
    /**
     * Get panel icon
     *
     * @return string
     */
    public function getIcon(): string;

    /**
     * Get panel id
     *
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * Panel requirements is valid
     *
     * @return bool
     */
    public function valid(): bool;
}
