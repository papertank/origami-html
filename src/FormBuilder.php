<?php

namespace Origami\Html;

use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Spatie\Html\Elements\Element;
use Spatie\Html\Elements\Input;
use Spatie\Html\Elements\Label;
use Spatie\Html\Elements\Textarea;

class FormBuilder
{
    use Macroable;

    protected Html $html;

    public function __construct(Html $html)
    {
        $this->html = $html;
    }

    public function element(array $options = [])
    {
        $attributes = Arr::except($options, ['method', 'url', 'route', 'action', 'files']);
        $html = $this->html->form(
            method: Arr::get($options, 'method', 'POST'),
            action: Arr::get($options, 'action')
        );

        if (Arr::get($options, 'files')) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        $html->attributes($attributes);

        return $html;
    }

    public function open(array $options = [])
    {
        return $this->element($options)->open();
    }

    public function close(array $options = [])
    {
        return $this->element($options)->close();
    }

    /**
     * Create a form label element.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $attributes
     * @param  bool  $escape_html
     * @return Label
     */
    public function label($name, $value = null, $attributes = [], $escape_html = true)
    {
        return $this->html->label(contents: $value, for: $name)->attributes($attributes);
    }

    /**
     * Create a form input field.
     *
     * @param  string  $type
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function input($type, $name, $value = null, $options = [])
    {
        return $this->html->input(
            type: $type,
            name: $name,
            value: $value,
        )->attributes($options);
    }

    /**
     * Create a text input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function text($name, $value = null, $options = [])
    {
        return $this->input('text', $name, $value, $options);
    }

    /**
     * Create a password input field.
     *
     * @param  string  $name
     * @param  array  $options
     * @return Input
     */
    public function password($name, $options = [])
    {
        return $this->input('password', $name, '', $options);
    }

    /**
     * Create a range input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function range($name, $value = null, $options = [])
    {
        return $this->input('range', $name, $value, $options);
    }

    /**
     * Create a hidden input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function hidden($name, $value = null, $options = [])
    {
        return $this->input('hidden', $name, $value, $options);
    }

    /**
     * Create a search input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function search($name, $value = null, $options = [])
    {
        return $this->input('search', $name, $value, $options);
    }

    /**
     * Create an e-mail input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function email($name, $value = null, $options = [])
    {
        return $this->input('email', $name, $value, $options);
    }

    /**
     * Create a tel input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function tel($name, $value = null, $options = [])
    {
        return $this->input('tel', $name, $value, $options);
    }

    /**
     * Create a number input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function number($name, $value = null, $options = [])
    {
        return $this->input('number', $name, $value, $options);
    }

    /**
     * Create a date input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function date($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return $this->input('date', $name, $value, $options);
    }

    /**
     * Create a datetime input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function datetime($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format(DateTime::RFC3339);
        }

        return $this->input('datetime', $name, $value, $options);
    }

    /**
     * Create a datetime-local input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function datetimeLocal($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d\TH:i');
        }

        return $this->input('datetime-local', $name, $value, $options);
    }

    /**
     * Create a time input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function time($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('H:i');
        }

        return $this->input('time', $name, $value, $options);
    }

    /**
     * Create a url input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function url($name, $value = null, $options = [])
    {
        return $this->input('url', $name, $value, $options);
    }

    /**
     * Create a week input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function week($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-\WW');
        }

        return $this->input('week', $name, $value, $options);
    }

    /**
     * Create a file input field.
     *
     * @param  string  $name
     * @param  array  $options
     * @return Input
     */
    public function file($name, $options = [])
    {
        return $this->input('file', $name, null, $options);
    }

    /**
     * Create a textarea input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Textarea
     */
    public function textarea($name, $value = null, $options = [])
    {
        return $this->html->textarea(
            name: $name,
            value: $value,
        )->attributes($options);
    }
}
