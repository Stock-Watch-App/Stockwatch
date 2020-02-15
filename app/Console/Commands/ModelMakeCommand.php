<?php

namespace tbirrell\LaravelModelDirectory\Console;

use Illuminate\Foundation\Console\ModelMakeCommand as BaseModelMakeCommand;

class ModelMakeCommand extends BaseModelMakeCommand
{
    protected function getStub()
    {
        if ($this->option('pivot')) {
            return __DIR__ . '../stubs/pivot.model.stub';
        }

        return __DIR__ . '../stubs/model.stub';
    }

    protected function getPath($name)
    {
        return parent::getPath("Models/$name");
    }
}
