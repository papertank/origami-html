<?php

namespace Origami\Html;

use Exception;
use Illuminate\Support\Traits\Macroable;
use Spatie\Html\Elements\Element;

class HtmlBuilder
{
    use Macroable;

    protected Html $html;

    public function __construct(Html $html)
    {
        $this->html = $html;
    }

    /**
     * Convert an HTML string to entities.
     *
     * @param  string  $value
     * @return string
     */
    public function entities($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }

    /**
     * Convert entities to HTML characters.
     *
     * @param  string  $value
     * @return string
     */
    public function decode($value)
    {
        return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Generate a link to a JavaScript file.
     *
     * @param  string  $url
     * @param  array  $attributes
     * @param  bool  $secure
     * @return string
     */
    public function script($url, $attributes = [], $secure = null)
    {
        $attributes['src'] = asset($url, $secure);

        return $this->html->element('script')->attributes($attributes);
    }

    /**
     * Generate a link to a CSS file.
     *
     * @param  string  $url
     * @param  array  $attributes
     * @param  bool  $secure
     * @return string
     */
    public function style($url, $attributes = [], $secure = null)
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];
        $attributes = array_merge($defaults, $attributes);
        $attributes['href'] = asset($url, $secure);

        return $this->html->element('link')->attributes($attributes);
    }

    /**
     * Generate an HTML image element.
     *
     * @param  string  $url
     * @param  string  $alt
     * @param  array  $attributes
     * @param  bool  $secure
     * @return string
     */
    public function image($url, $alt = null, $attributes = [], $secure = null)
    {
        $attributes['alt'] = $alt;

        return $this->html->img(src: asset($url, $secure), alt: $alt)->attributes($attributes);
    }

    /**
     * Generate a link to a Favicon file.
     *
     * @param  string  $url
     * @param  array  $attributes
     * @param  bool  $secure
     * @return string
     */
    public function favicon($url, $attributes = [], $secure = null)
    {
        $defaults = ['rel' => 'shortcut icon', 'type' => 'image/x-icon'];
        $attributes = array_merge($defaults, $attributes);
        $attributes['href'] = asset($url, $secure);

        return $this->html->element('link')->attributes($attributes);
    }

    /**
     * Generate a HTML link.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array  $attributes
     * @param  bool  $secure
     * @param  bool  $escape
     * @return string
     */
    public function link($url, $title = null, $attributes = [], $secure = null, $escape = true)
    {
        $url = url($url, [], $secure);

        if (is_null($title) || $title === false) {
            $title = $url;
        }

        if ($escape) {
            $title = $this->entities($title);
        }

        return $this->html->a(href: $this->entities($url), contents: $title)->attributes($attributes);
    }

    /**
     * Generate a HTTPS HTML link.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array  $attributes
     * @param  bool  $escape
     * @return string
     */
    public function secureLink($url, $title = null, $attributes = [], $escape = true)
    {
        return $this->link($url, $title, $attributes, true, $escape);
    }

    /**
     * Generate a HTML link to an asset.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array  $attributes
     * @param  bool  $secure
     * @param  bool  $escape
     * @return string
     */
    public function linkAsset($url, $title = null, $attributes = [], $secure = null, $escape = true)
    {
        $url = asset($url, $secure);

        return $this->link($url, $title ?: $url, $attributes, $secure, $escape);
    }

    /**
     * Generate a HTTPS HTML link to an asset.
     *
     * @param  string  $url
     * @param  string  $title
     * @param  array  $attributes
     * @param  bool  $escape
     * @return string
     */
    public function linkSecureAsset($url, $title = null, $attributes = [], $escape = true)
    {
        return $this->linkAsset($url, $title, $attributes, true, $escape);
    }

    /**
     * Generate a HTML link to a named route.
     *
     * @param  string  $name
     * @param  string  $title
     * @param  array  $parameters
     * @param  array  $attributes
     * @param  bool  $secure
     * @param  bool  $escape
     * @return string
     */
    public function linkRoute($name, $title = null, $parameters = [], $attributes = [], $secure = null, $escape = true)
    {
        return $this->link(route($name, $parameters), $title, $attributes, $secure, $escape);
    }

    /**
     * Generate a HTML link to a controller action.
     *
     * @param  string  $action
     * @param  string  $title
     * @param  array  $parameters
     * @param  array  $attributes
     * @param  bool  $secure
     * @param  bool  $escape
     * @return string
     */
    public function linkAction($action, $title = null, $parameters = [], $attributes = [], $secure = null, $escape = true)
    {
        return $this->link(action($action, $parameters), $title, $attributes, $secure, $escape);
    }

    /**
     * Generate a HTML link to an email address.
     *
     * @param  string  $email
     * @param  string  $title
     * @param  array  $attributes
     * @param  bool  $escape
     * @return string
     */
    public function mailto($email, $title = null, $attributes = [], $escape = true)
    {
        $email = $this->email($email);

        $title = $title ?: $email;

        if ($escape) {
            $title = $this->entities($title);
        }

        $email = $this->obfuscate('mailto:').$email;

        return $this->html->a(href: $email, contents: $title)->attributes($attributes);
    }

    /**
     * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
     *
     * @param  string  $email
     * @return string
     */
    public function email($email)
    {
        return str_replace('@', '&#64;', $this->obfuscate($email));
    }

    /**
     * Generates non-breaking space entities based on number supplied.
     *
     * @param  int  $num
     * @return string
     */
    public function nbsp($num = 1)
    {
        return str_repeat('&nbsp;', $num);
    }

    /**
     * Generate an ordered list of items.
     *
     * @param  array  $list
     * @param  array  $attributes
     * @return string
     */
    public function ol($list, $attributes = [])
    {
        return $this->listing('ol', $list, $attributes);
    }

    /**
     * Generate an un-ordered list of items.
     *
     * @param  array  $list
     * @param  array  $attributes
     * @return string
     */
    public function ul($list, $attributes = [])
    {
        return $this->listing('ul', $list, $attributes);
    }

    /**
     * Generate a description list of items.
     *
     *
     * @return string
     */
    public function dl(array $list, array $attributes = [])
    {
        throw new Exception('TODO');
        //        $attributes = $this->attributes($attributes);
        //
        //        $html = "<dl{$attributes}>";
        //
        //        foreach ($list as $key => $value) {
        //            $value = (array) $value;
        //
        //            $html .= "<dt>$key</dt>";
        //
        //            foreach ($value as $v_key => $v_value) {
        //                $html .= "<dd>$v_value</dd>";
        //            }
        //        }
        //
        //        $html .= '</dl>';
        //
        //        return $this->toHtmlString($html);
    }

    /**
     * Create a listing HTML element.
     *
     * @param  string  $type
     * @param  array  $list
     * @param  array  $attributes
     * @return Element
     */
    protected function listing($type, $list, $attributes = [])
    {
        if (! in_array($type, ['ol', 'ul'])) {
            throw new Exception('Unsupported list type');
        }

        $html = $this->html->element($type)->attributes($attributes);

        if (count($list) === 0) {
            return $html;
        }

        // Essentially we will just spin through the list and build the list of the HTML
        // elements from the array. We will also handled nested lists in case that is
        // present in the array. Then we will build out the final listing elements.
        foreach ($list as $key => $value) {
            $html->addChild(
                $this->listingElement($key, $type, $value)
            );
        }

        return $html;
    }

    /**
     * Create the HTML for a listing element.
     *
     * @param  mixed  $key
     * @param  string  $type
     * @param  mixed  $value
     * @return Element
     */
    protected function listingElement($key, $type, $value)
    {
        if (is_array($value)) {
            return $this->nestedListing($key, $type, $value);
        } else {
            return $this->html->element('li')->html($value);
        }
    }

    /**
     * Create the HTML for a nested listing attribute.
     *
     * @param  mixed  $key
     * @param  string  $type
     * @param  mixed  $value
     * @return Element
     */
    protected function nestedListing($key, $type, $value)
    {
        if (is_int($key)) {
            return $this->listing($type, $value);
        } else {
            return $this->html->element('li')->addChild(
                $this->listing($type, $value)
            );
        }
    }
}
