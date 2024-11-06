<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SoftDeletingScope implements Scope
{
    /**
     * All the extensions to be added to the builder.
     *
     * @var array
     */
    protected array $extensions = ['Restore', 'WithTrashed', 'WithoutTrashed', 'OnlyTrashed'];

    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where($model->qualifyColumn('is_deleted'), 0);
    }

    /**
     * Extend the query builder with the needed functions.
     *
     * @param  Builder  $builder
     * @return void
     */
    public function extend(Builder $builder): void
    {
        foreach ($this->extensions as $extension) {
            $this->{"add{$extension}"}($builder);
        }

        $builder->onDelete(function (Builder $builder) {
            $column = $this->getDeletedAtColumn($builder);

            return $builder->update([
                $column      => $builder->getModel()->freshTimestampString(),
                'is_deleted' => 1,
            ]);
        });
    }

    /**
     * Get the "deleted at" column for the builder.
     *
     * @param  Builder  $builder
     * @return string
     */
    protected function getDeletedAtColumn(Builder $builder): string
    {
        if (count((array) $builder->getQuery()->joins) > 0) {
            return $builder->getModel()->getQualifiedDeletedAtColumn();
        }

        return $builder->getModel()->getDeletedAtColumn();
    }

    /**
     * Add the restore extension to the builder.
     *
     * @param  Builder  $builder
     * @return void
     */
    protected function addRestore(Builder $builder): void
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withTrashed();

            return $builder->update(['is_deleted' => 0]);
        });
    }

    /**
     * Add the with-trashed extension to the builder.
     *
     * @param  Builder  $builder
     * @return void
     */
    protected function addWithTrashed(Builder $builder): void
    {
        $builder->macro('withTrashed', function (Builder $builder, $withTrashed = true) {
            if (! $withTrashed) {
                return $builder->withoutTrashed();
            }

            return $builder->withoutGlobalScope($this);
        });
    }

    /**
     * Add the without-trashed extension to the builder.
     *
     * @param  Builder  $builder
     * @return void
     */
    protected function addWithoutTrashed(Builder $builder): void
    {
        $builder->macro('withoutTrashed', function (Builder $builder) {
            $builder->withoutGlobalScope($this)->where($builder->qualifyColumn('is_deleted'), 0);

            return $builder;
        });
    }

    /**
     * Add the only-trashed extension to the builder.
     *
     * @param  Builder  $builder
     * @return void
     */
    protected function addOnlyTrashed(Builder $builder): void
    {
        $builder->macro('onlyTrashed', function (Builder $builder) {
            $builder->withoutGlobalScope($this)->where($builder->qualifyColumn('is_deleted'), 1);

            return $builder;
        });
    }
}
