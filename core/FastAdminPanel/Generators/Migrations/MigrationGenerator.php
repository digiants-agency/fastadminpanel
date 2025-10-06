<?php

namespace App\FastAdminPanel\Generators\Migrations;

class MigrationGenerator
{
    public function create($table, $type = '', $fields = '', $isMultilanguage = false, $filename = '')
    {
        $stub = $this->getStub($type, $isMultilanguage);
        $filename = $filename ? $filename : $this->getDatePrefix().'_'.$type.'_'.$table.'.php';
        $path = $this->getPath($filename);

        file_put_contents(
            $path,
            $this->populateStub($stub, $table, $fields)
        );
    }

    public function stubPath($path)
    {
        return __DIR__.'/stubs/'.$path;
    }

    protected function getStub($type, $isMultilanguage)
    {
        if (! in_array($type, ['create', 'update', 'delete'])) {
            return;
        }

        $multilanguage = $isMultilanguage ? '.multilanguage' : '';

        $stub = $this->stubPath("migration.{$type}{$multilanguage}.stub");

        return file_get_contents($stub);
    }

    protected function populateStub($stub, $table, $fields, $unfields = '')
    {
        return str_replace(
            ['{{ table }}', '{{ fields }}', '{{ unfields }}'],
            [$table, $fields, $unfields],
            $stub
        );
    }

    protected function getPath($name)
    {
        return database_path('migrations').'/'.$name;
    }

    protected function getDatePrefix()
    {
        return date('Y_m_d_His');
    }
}
