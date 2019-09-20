<?php

namespace Yajra\DataTables\Html;

use Illuminate\Support\Fluent;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Auth\Access\Authorizable;

class Button extends Fluent implements Arrayable
{
    /**
     * Flag to check if user is authorized to use the button.
     *
     * @var bool
     */
    protected $authorized = true;

    /**
     * Make a button if condition is true.
     *
     * @param bool|callable $condition
     * @param string|array $options
     * @return Button
     */
    public static function makeIf($condition, $options)
    {
        if (value($condition)) {
            return static::make($options);
        }

        return static::make()->authorized(false);
    }

    /**
     * Make a new button instance.
     *
     * @param string|array $options
     * @return Button
     */
    public static function make($options = [])
    {
        if (is_string($options)) {
            return new static(['extend' => $options]);
        }

        return new static($options);
    }

    /**
     * Set authotization status of the button.
     *
     * @param bool|callable $bool
     * @return $this
     */
    public function authorized($bool)
    {
        $this->authorized = value($bool);

        return $this;
    }

    /**
     * Make a raw button that does not extend anything.
     *
     * @param array $options
     * @return \Yajra\DataTables\Html\Button
     */
    public static function raw($options = [])
    {
        if (is_string($options)) {
            return new static(['text' => $options]);
        }

        return new static($options);
    }

    /**
     * Make a button if condition is true.
     *
     * @param string $permission
     * @param string|array $options
     * @param Authorizable|null $user
     * @return Button
     */
    public static function makeIfCan($permission, $options, Authorizable $user = null)
    {
        if (is_null($user)) {
            $user = auth()->user();
        }

        if ($user->can($permission)) {
            return static::make($options);
        }

        return static::make()->authorized(false);
    }

    /**
     * Set extend option value.
     *
     * @param string $value
     * @return $this
     */
    public function extend($value)
    {
        $this->attributes['extend'] = $value;

        return $this;
    }

    /**
     * Set editor option value.
     *
     * @param string $value
     * @return $this
     */
    public function editor($value)
    {
        $this->attributes['editor'] = $value;

        return $this;
    }

    /**
     * @param array $buttons
     * @return $this
     */
    public function buttons(array $buttons)
    {
        foreach ($buttons as $key => $button) {
            if ($button instanceof Arrayable) {
                $buttons[$key] = $button->toArray();
            }
        }

        $this->attributes['buttons'] = $buttons;

        return $this;
    }

    /**
     * @param array $buttons
     * @return $this
     * @see https://editor.datatables.net/examples/api/cancelButton
     */
    public function formButtons(array $buttons)
    {
        foreach ($buttons as $key => $button) {
            if ($button instanceof Arrayable) {
                $buttons[$key] = $button->toArray();
            }
        }

        $this->attributes['formButtons'] = $buttons;

        return $this;
    }

    /**
     * Set className option value.
     *
     * @param string $value
     * @return $this
     */
    public function className($value)
    {
        $this->attributes['className'] = $value;

        return $this;
    }

    /**
     * Set action option value.
     *
     * @param string $value
     * @return $this
     */
    public function action($value)
    {
        $this->attributes['action'] = $value;

        return $this;
    }

    /**
     * Set text option value.
     *
     * @param string $value
     * @return $this
     */
    public function text($value)
    {
        $this->attributes['text'] = $value;

        return $this;
    }

    /**
     * Set columns option value.
     *
     * @param mixed $value
     * @return $this
     */
    public function columns($value)
    {
        $this->attributes['columns'] = $value;

        return $this;
    }

    /**
     * Set exportOptions option value.
     *
     * @param mixed $value
     * @return $this
     */
    public function exportOptions($value)
    {
        $this->attributes['exportOptions'] = $value;

        return $this;
    }

    /**
     * Convert the Fluent instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        if ($this->authorized) {
            return parent::toArray();
        }

        return [];
    }
}
