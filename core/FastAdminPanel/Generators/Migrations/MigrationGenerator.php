<?php

namespace App\FastAdminPanel\Generators\Migrations;

class MigrationGenerator
{
    public function create($table, $type = '', $fields = '')
    {
        $stub = $this->getStub($type);
        $path = $this->getPath($type.'_'.$table);

        file_put_contents(
            $path, 
            $this->populateStub($stub, $table, $fields)
        );
    }

    protected function getStub($type)
    {
        if (!in_array($type, ['create', 'update', 'delete'])) {
            return;
        }

        $stub = $this->stubPath('migration.'.$type.'.stub');

        return file_get_contents($stub);
    }

    protected function populateStub($stub, $table, $fields)
    {
        return str_replace(
            ['{{ table }}', '{{ fields }}'],
            [$table, $fields],
            $stub
        );
    }

    protected function getPath($name)
    {
        return database_path("migrations").'/'.$this->getDatePrefix().'_'.$name.'.php';
    }

    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }

    public function stubPath($path)
    {
        return __DIR__.'/stubs/'.$path;
    }
}
