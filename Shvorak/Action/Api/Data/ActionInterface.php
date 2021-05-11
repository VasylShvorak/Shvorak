<?php


namespace Shvorak\Action\Api\Data;


interface ActionInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string|null
     */
    public function getDescription();
}
