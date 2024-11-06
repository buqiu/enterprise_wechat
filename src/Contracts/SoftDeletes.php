<?php

declare(strict_types=1);

namespace Buqiu\EnterpriseWechat\Contracts;

use Closure;

/**
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder withTrashed()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder onlyTrashed()
 * @method static static|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder withoutTrashed()
 */
trait SoftDeletes
{
    /**
     * Indicates if the model is currently force deleting.
     *
     * @var bool
     */
    protected $forceDeleting = false;

    /**
     * @var int
     */
    protected int $deleteAt = 1;

    /**
     * Boot the soft deleting trait for a model.
     *
     * @return void
     */
    public static function bootSoftDeletes(): void
    {
        static::addGlobalScope(new SoftDeletingScope);
    }

    /**
     * Force a hard delete on a soft deleted model.
     */
    public function forceDelete()
    {
        $this->forceDeleting = true;

        return tap($this->delete(), function ($deleted) {
            $this->forceDeleting = false;

            if ($deleted) {
                $this->fireModelEvent('forceDeleted', false);
            }
        });
    }

    /**
     * Perform the actual delete query on this model instance.
     */
    protected function performDeleteOnModel()
    {
        if ($this->forceDeleting) {
            $this->exists = false;

            return $this->setKeysForSaveQuery($this->newModelQuery())->forceDelete();
        }

        return $this->runSoftDelete();
    }

    /**
     * Perform the actual delete query on this model instance.
     */
    protected function runSoftDelete(): int
    {
        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $this->{$this->getDeletedAtColumn()} = $this->deleteAt;

        $columns = $this->getDirty();

        $time = $this->freshTimestamp();

        if ($this->timestamps && ! is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        $result = $query->update($columns);

        $this->syncOriginalAttributes(array_keys($columns));

        return $result;
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function restore(): ?bool
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = 0;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    /**
     * Create Or Restore a soft-deleted model instance.
     *
     * @param  int  $is_deleted
     * @return bool|null
     */
    public function saveRestore(int $is_deleted = 0): ?bool
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = $is_deleted;

        $result = $this->save();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    /**
     * Update Or Restore a soft-deleted model instance.
     *
     * @return bool|null
     */
    public function updateRestore(): ?bool
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('restoring') === false) {
            return false;
        }

        $this->{$this->getDeletedAtColumn()} = 0;

        $result = $this->update();

        $this->fireModelEvent('restored', false);

        return $result;
    }

    public function reset(array $column = []): static
    {
        if ($this->trashed()) {
            foreach ($this->getAttributes() as $key => $value) {
                if (in_array($key, ['id', 'corp_id', 'created_at', 'updated_at', 'is_deleted'])) {
                    continue;
                }
                if (in_array($key, $column)) {
                    continue;
                }
                if (is_array($value)) {
                    $this->setAttribute($key, null);
                } elseif (is_int($value)) {
                    $this->setAttribute($key, 0);
                } elseif (is_string($value)) {
                    $this->setAttribute($key, '');
                } else {
                    $this->setAttribute($key, null);
                }
            }
        }

        return $this;
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function trashed(): bool
    {
        return ! empty($this->{$this->getDeletedAtColumn()});
    }

    /**
     * Register a restoring model event with the dispatcher.
     *
     * @param  Closure|string  $callback
     * @return void
     */
    public static function restoring($callback): void
    {
        static::registerModelEvent('restoring', $callback);
    }

    /**
     * Register a restored model event with the dispatcher.
     *
     * @param  Closure|string  $callback
     * @return void
     */
    public static function restored($callback): void
    {
        static::registerModelEvent('restored', $callback);
    }

    /**
     * Determine if the model is currently force deleting.
     *
     * @return bool
     */
    public function isForceDeleting(): bool
    {
        return $this->forceDeleting;
    }

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getDeletedAtColumn(): string
    {
        return 'is_deleted';
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedDeletedAtColumn(): string
    {
        return $this->qualifyColumn($this->getDeletedAtColumn());
    }
}
