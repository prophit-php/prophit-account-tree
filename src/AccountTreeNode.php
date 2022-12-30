<?php

namespace Prophit\AccountTree;

use loophp\phptree\{
    Node\ValueNode,
    Traverser\TraverserInterface,
};

class AccountTreeNode extends ValueNode
{
    public function __construct(
        Account $account,
        ?TraverserInterface $traverser = null,
        ?AccountTreeNode $parent = null,
    ) {
        parent::__construct($account, 0, $traverser, $parent);
    }
}
