# Account Tree

Tree implementation for hierarchical accounts in Prophit.

Released under the [MIT License](https://en.wikipedia.org/wiki/MIT_License).

## Installation

```sh
composer require prophit/account-tree
```

## Accounts

`prophit/core` provides an `Account` entity class for accounts, but it has no sense of accounts forming a hierarchy.

```php
<?php

use Prophit\Core\Account\Account;

$account = new Account(
    'ID-GOES-HERE',
    'NAME-GOES_HERE',
);
```

This library extends that `Account` class to support the notion of parent-child relationships between accounts. To do so, it adds a constructor parameter `$parentId`, which should take on the value of the `$id` property of the `Account` instance corresponding to the parent account.

```php
<?php

use Prophit\AccountTree\Account;

// The $parentId constructor parameter is not specified here and defaults to null,
// which is used to indicate that the account does not have a parent.
$parentAccount = new Account('PARENT-ID', 'Parent Account');

// The $parentId constructor parameter is specified here to indicate that this
// account is a child of the above parent account.
$childAccount = new Account('CHILD-ID', 'Child Account', $parentAccount->getId());

// The $parentId constructor parameter is specified here to indicate that this
// account is a child of the above child account.
$grandchildAccount = new Account('GRANDCHILD-ID', 'Grandchild Account', $childAccount->getId());
```

## Tree

This library provides an `AccountTree` class, which takes an `iterable` collection of `Account` instances as its only constructor parameter. `AccountTree` is iterable and uses [`loophp/phptree`](https://github.com/loophp/phptree) under the hood to perform a [pre-order traversal](https://en.wikipedia.org/wiki/Tree_traversal#Pre-order,_NLR) of the accounts.

When `AccountTree` iterates over an account, it returns an instance of that account with an additional property populated to represent the depth of the account within the tree. This depth can be retrieved using the `getDepth()` method of the account instance.

These features together are useful for rendering an account list visualized as a tree within a user interface.

```php
<?php

// From the earlier example:
// $parentAccount = ...
// $childAccount = ...
// $grandchildAccount = ...

use Prophit\AccountTree\AccountTree;

$tree = new AccountTree([
    $parentAccount,
    $childAccount,
    $grandchildAccount,
]);
foreach ($tree as $account) {
    echo str_repeat('  ', $account->getDepth()), $account->getName(), PHP_EOL;
}

// Output:
// Parent Account
//   Child Account
//     Grandchild Account
```
