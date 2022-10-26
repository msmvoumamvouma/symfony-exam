<?php

namespace App\Service;

class File
{
    public function __construct(
        public readonly string $name,
    ) {
    }
}

class Directory
{
    /**
     * @param (File|Directory)[] $children
     */
    public function __construct(
        public readonly string $name,
        public readonly array $children,
    ) {
    }
}

class VisitFiles
{
    /**
     * Traverse Files & Directories.
     *
     * Return a list of every files filtered by given function.
     *
     * @param Directory|File $root
     */
    public function visitFiles($root, callable $filterFn): void
    {
        if ($root instanceof Directory) {
            foreach ($root->children as $item) {
                $this->visitFiles($item, $filterFn);
            }
        }
        if ($root instanceof File) {
            $filterFn($root);
        }
    }

    public function usageExemple(): void
    {
        $subDirectory = new Directory('embrace change', [
            new File('dd'),
            new File('cc'),
            new File('mm'),
        ]);

        $directory = new Directory('xp', [
            new File('ll'),
            new File('pp'),
            new File('op'),
            $subDirectory,
        ]);

        $this->visitFiles(
            $directory,
            function ($file) {
                $name = $file->name;
                for ($i = 0; $i < floor(strlen($name)); ++$i) {
                    if ($name[$i] != $name[strlen($name) - $i - 1]) {
                        return false;
                    }
                }

                return true;
            }
        );
    }
}
