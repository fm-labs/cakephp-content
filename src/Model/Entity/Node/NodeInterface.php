<?php

namespace Content\Model\Entity\Node;


interface NodeInterface
{
    public function getNodeLabel();
    public function getNodeUrl();
    public function isNodeEnabled();
    public function getChildNodes();
}