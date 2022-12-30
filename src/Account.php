<?php

namespace Prophit\AccountTree;

use Prophit\Core\Account\Account as BaseAccount;

class Account extends BaseAccount
{
    public function __construct(
        string $id,
        string $name,
        private ?string $parentId = null,
    ) {
        parent::__construct($id, $name);
    }

    public function getParentId(): ?string
    {
        return $this->parentId;
    }

    public function hasParent(): bool
    {
        return $this->parentId !== null;
    }
}
