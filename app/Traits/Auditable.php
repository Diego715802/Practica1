<?php

namespace App\Traits;

use App\Models\Audit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static void created(\Closure $callback)
 * @method static void updated(\Closure $callback)
 * @method static void deleted(\Closure $callback)
 */
trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function (Model $model) {
            static::createAudit($model, 'create', null, $model->toArray());
        });

        static::updated(function (Model $model) {
            static::createAudit($model, 'update', $model->getOriginal(), $model->getChanges());
        });

        static::deleted(function (Model $model) {
            static::createAudit($model, 'delete', $model->toArray(), null);
        });
    }

    protected static function createAudit(Model $model, string $action, ?array $oldValues, ?array $newValues)
    {
        Audit::create([
            'user_name' => Auth::check() ? Auth::user()->name : 'System',
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => $action,
            'old_values' => $oldValues, // <-- Ya le mandamos el arreglo directo
            'new_values' => $newValues, // <-- Ya le mandamos el arreglo directo
            'ip_address' => (string) Request::ip(),
            'user_agent' => (string) Request::userAgent(),
        ]);
    }
}
