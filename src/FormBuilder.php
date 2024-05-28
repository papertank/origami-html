<?php

namespace Origami\Html;

use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Traits\Macroable;
use Spatie\Html\Elements\Button;
use Spatie\Html\Elements\Element;
use Spatie\Html\Elements\Form;
use Spatie\Html\Elements\Input;
use Spatie\Html\Elements\Label;
use Spatie\Html\Elements\Select;
use Spatie\Html\Elements\Textarea;

class FormBuilder
{
    use Macroable;

    protected Html $html;

    public function __construct(Html $html)
    {
        $this->html = $html;
    }

    public function element(array $options = []): Form
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

    public function open(array $options = []): string
    {
        return $this->element($options)->open();
    }

    public function close(array $options = []): string
    {
        return $this->element($options)->close();
    }

    /**
     * Generate a hidden field with the current CSRF token.
     */
    public function token(): Input
    {
        return $this->html->token();
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

    /**
     * Create a select box field.
     *
     * @param  string  $name
     * @param  array  $list
     * @param  string|bool  $selected
     * @return Select
     */
    public function select(
        $name,
        $list = [],
        $selected = null,
        array $attributes = [],
    ) {
        $html = $this->html->select(name: $name, value: $selected)->attributes(Arr::except($attributes, 'placeholder'));

        if ($placeholder = Arr::get($attributes, 'placeholder')) {
            $html->placeholder($placeholder);
        }

        $html->options($list);

        return $html;
    }

    /**
     * Create a select range field.
     *
     * @param  string  $name
     * @param  string  $begin
     * @param  string  $end
     * @param  string  $selected
     * @param  array  $options
     * @return Select
     */
    public function selectRange($name, $begin, $end, $selected = null, $options = [])
    {
        $range = array_combine($range = range($begin, $end), $range);

        return $this->select($name, $range, $selected, $options);
    }

    /**
     * Create a checkbox input field.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @param  bool  $checked
     * @param  array  $options
     * @return Input
     */
    public function checkbox($name, $value = 1, $checked = null, $options = [])
    {
        return $this->html->checkbox(
            name: $name,
            value: $value,
            checked: $checked,
        )->attributes($options);
    }

    /**
     * Create a radio button input field.
     *
     * @param  string  $name
     * @param  mixed  $value
     * @param  bool  $checked
     * @param  array  $options
     * @return Input
     */
    public function radio($name, $value = null, $checked = null, $options = [])
    {
        if (is_null($value)) {
            $value = $name;
        }

        return $this->html->radio(
            name: $name,
            value: $value,
            checked: $checked,
        )->attributes($options);
    }

    /**
     * Create a HTML image input element.
     *
     * @param  string  $url
     * @param  string  $name
     * @param  array  $attributes
     * @return Input
     */
    public function image($url, $name = null, $attributes = [])
    {
        $attributes['src'] = asset($url);

        return $this->html->input('image', $name, null)->attributes($attributes);
    }

    /**
     * Create a month input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function month($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m');
        }

        return $this->input('month', $name, $value, $options);
    }

    /**
     * Create a color input field.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function color($name, $value = null, $options = [])
    {
        return $this->input('color', $name, $value, $options);
    }

    /**
     * Create a submit button element.
     *
     * @param  string  $value
     * @param  array  $options
     * @return Input
     */
    public function submit($value = null, $options = [])
    {
        return $this->input('submit', null, $value, $options);
    }

    /**
     * Create a button element.
     *
     * @param  string  $value
     * @param  array  $options
     * @return Button
     */
    public function button($value = null, $options = [])
    {
        $type = Arr::get($options, 'type', 'button');

        return $this->html->button(
            contents: $value,
            type: $type
        )->attributes(Arr::except($options, ['type']));
    }
}
