<?php

namespace Prophit\AccountTree;

use Prophit\Core\Account\Account as BaseAccount;

class Account extends BaseAccount
{
    public function __construct(
        string $id,
        string $name,
        string $currency,
        private ?string $parentId = null,
        private ?int $depth = null,
    ) {
        parent::__construct($id, $name, $currency);
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function hasParent(): bool
    {
        return $this->parentId !== null;
    }

    /**
     * @param int $depth Account depth within the tree, >= 0
     */
    public function withDepth(int $depth): self
    {
        $clone = clone $this;
        $clone->depth = $depth;
        return $clone;
    }

    /**
     * @return int Account depth within the tree, >= 0
     */
    public function getDepth(): ?int
    {
        return $this->depth;
    }
}
