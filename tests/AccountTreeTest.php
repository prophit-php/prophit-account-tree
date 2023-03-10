<?php

use Prophit\Core\Account\AccountIterator;

use Prophit\AccountTree\{
    Account,
    AccountTree,
    AccountTreeNode,
};

test('iterates depth-first', function () {
    $accounts = [
        new Account('1', 'Root 1'),
        new Account('2', 'Root 2'),
        new Account('3', 'Child 1-2', '1'),
        new Account('4', 'Child 1-1', '1'),
        new Account('5', 'Grandchild 1-1', '4'),
        new Account('6', 'Child 2-1', '2'),
        new Account('7', 'Grandchild 2-1', '6'),
    ];
    $iterator = new AccountIterator(...$accounts);
    $tree = new AccountTree($iterator);

    $expectedAccountIds = [ '1', '4', '5', '3', '2', '6', '7' ];
    $actualAccountIds = array_map(
        fn(Account $account): string => $account->getId(),
        iterator_to_array($tree),
    );
    expect($expectedAccountIds)->toBe($actualAccountIds);

    $expectedAccountDepths = [0, 1, 2, 1, 0, 1, 2];
    $actualAccountDepths = array_map(
        fn(Account $account): int => $account->getDepth(),
        iterator_to_array($tree),
    );
    expect($expectedAccountDepths)->toBe($actualAccountDepths);
});
