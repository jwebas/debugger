<?php
declare(strict_types=1);


namespace Jwebas\Debugger\Support;


interface PanelInterface
{
    /**
     * Get panel content
     *
     * @return string
     */
    public function getContent(): string;

    /**
     * Get panel data
     *
     * @return array
     */
    public function getData(): array;

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
