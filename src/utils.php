<?php

namespace MiraiSdk\utils;

use Amp\Promise;

/**
 * @param Promise<T> $promise
 * @param callable $fn(T): R
 * @return Promise<R>
 */
function map_promise(Promise $promise, callable $fn): Promise {
    return \Amp\call(function () use($promise, $fn) {
        return $fn(yield $promise);
    });
}