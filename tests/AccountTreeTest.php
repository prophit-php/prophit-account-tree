<?php

use Prophit\AccountTree\{
    Account,
    AccountTree,
    AccountTreeNode,
};

test('iterates depth-first', function () {
    $accounts = [
        new Account('1', 'Root 1', 'USD'),
        new Account('2', 'Root 2', 'USD'),
        new Account('3', 'Child 1-2', 'USD', '1'),
        new Account('4', 'Child 1-1', 'USD', '1'),
        new Account('5', 'Grandchild 1-1', 'USD', '4'),
        new Account('6', 'Child 2-1', 'USD', '2'),
        new Account('7', 'Grandchild 2-1', 'USD', '6'),
    ];
    $tree = new AccountTree($accounts);

    $expectedAccountIds = [ '1', '4', '5', '3', '2', '6', '7' ];
    $actualAccountIds = array_map(
        fn(Account $account): string => $account->getId(),
        iterator_to_array($tree),
    );
    expect($expectedAccountIds)->toBe($actualAccountIds);

    $expectedAccountDepths = [0, 1, 2, 1, 0, 1, 2];
    $actualAccountDepths = array_map(
        fn(Account $account): ?int => $account->getDepth(),
        iterator_to_array($tree),
    );
    expect($expectedAccountDepths)->toBe($actualAccountDepths);
});
