<?php


namespace Shvorak\Action\Api;

interface ActionRepositoryInterface
{
    /**
     * @return \Shvorak\Action\Api\Data\ActionInterface[]
     */
    public function getList();

}
