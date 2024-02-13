<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasSlug
{
    protected  static function bootHasSlug(): void
    {
        static::creating(function (Model $item) {
           $item->makeSlug();
        });
    }

    protected function makeSlug(): void
    {
        if(!$this->{$this->slugColumn()}){
            $slug = $this->slugUnique(

                Str::of($this->{$this->slugForm()})
                    ->slug()
                    ->value()
            );
            $this->{$this->slugColumn()} = $slug;
        }
    }

    protected function slugColumn(): string
    {
        return 'slug';
    }

    protected function slugForm(): string
    {
        return 'name';
    }

    private function slugUnique(string $slug): string
    {
        $originalSlug = $slug;
        $i = 0;

        while ($this->isSlugExists($slug)) {
            $i++;
            $slug = $originalSlug.'-'.$i;
        }
        return $slug;
    }

    private function isSlugExists(string $slug): bool
    {
        $query = $this->newQuery()
            ->where(self::slugColumn(), $slug)
            ->where($this->getKeyName(), '!=', $this->getKey())
            ->withoutGlobalScopes();

        return $query->exists();
    }
}
