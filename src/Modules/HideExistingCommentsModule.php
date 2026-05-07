<?php

declare(strict_types=1);

namespace BrewAndBytes\AcornDisableComments\Modules;

class HideExistingCommentsModule extends AbstractModule
{
    public function handle(): void
    {
        if (! $this->enabled()) {
            return;
        }

        $this
            ->emptyArray('comments_array')
            ->zeroOut('get_comments_number');
    }
}
