<?php

it('will not use debugging functions')
    ->skip()
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();
