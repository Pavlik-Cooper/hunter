<?php

namespace App;


trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        // because we use auth()->id()

        if (auth()->guest()) return;

        //   static::getActivitiesToRecord()
        // because of the bootRecordsActivity method
        // this is as if it was in boot method of model that uses this trait

        foreach (static::getActivitiesToRecord() as $event) {
            // $model -- current model on which trait is being used
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function ($model) {
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event)
        ]);
    }

    public function activity()
    {
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$type}";
    }
}
