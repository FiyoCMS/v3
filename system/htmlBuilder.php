<?php

class HtmlBuilder
{
   
    public function __construct(UrlGenerator $url = null, Factory $view)
    {
        self::$url = $url;
        self::$view = $view;
    }
    /**
     * Convert an HTML string to entities.
     *
     * @param string $value
     *
     * @return string
     */
    public function entities($value)
    {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }
    /**
     * Convert all applicable characters to HTML entities.
     *
     * @param string $value
     *
     * @return string
     */
    public static function  escapeAll($value)
    {
        return @htmlentities($value, ENT_QUOTES, 'UTF-8');
    }
    /**
     * Convert entities to HTML characters.
     *
     * @param string $value
     *
     * @return string
     */
    public function decode($value)
    {
        return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }
    /**
     * Generate a link to a JavaScript file.
     *
     * @param string $url
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function script($url, $attributes = [], $secure = null)
    {
        $attributes['src'] = self::$url->asset($url, $secure);
        return self::toHtmlString('<script' . self::attributes($attributes) . '></script>' . PHP_EOL);
    }
    /**
     * Generate a link to a CSS file.
     *
     * @param string $url
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function style($url, $attributes = [], $secure = null)
    {
        $defaults = ['media' => 'all', 'type' => 'text/css', 'rel' => 'stylesheet'];
        $attributes = $attributes + $defaults;
        $attributes['href'] = self::$url->asset($url, $secure);
        return self::toHtmlString('<link' . self::attributes($attributes) . '>' . PHP_EOL);
    }
    /**
     * Generate an HTML image element.
     *
     * @param string $url
     * @param string $alt
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function images($url, $alt = null, $attributes = [], $secure = null)
    {
        $attributes['alt'] = $alt;
        return self::toHtmlString('<img src="' . self::$url->asset($url,
            $secure) . '"' . self::attributes($attributes) . '>');
    }
    /**
     * Generate a link to a Favicon file.
     *
     * @param string $url
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function favicon($url, $attributes = [], $secure = null)
    {
        $defaults = ['rel' => 'shortcut icon', 'type' => 'image/x-icon'];
        $attributes = $attributes + $defaults;
        $attributes['href'] = self::$url->asset($url, $secure);
        return self::toHtmlString('<link' . self::attributes($attributes) . '>' . PHP_EOL);
    }
    /**
     * Generate a HTML link.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $secure
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function link($url, $title = null, $attributes = [], $secure = null, $escape = true)
    {
        $url = self::$url->to($url, [], $secure);
        if (is_null($title) || $title === false) {
            $title = $url;
        }
        if ($escape) {
            $title = self::entities($title);
        }
        return self::toHtmlString('<a href="' . $url . '"' . self::attributes($attributes) . '>' . $title . '</a>');
    }
    /**
     * Generate a HTTPS HTML link.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function secureLink($url, $title = null, $attributes = [])
    {
        return self::link($url, $title, $attributes, true);
    }
    /**
     * Generate a HTML link to an asset.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     * @param bool   $secure
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function linkAsset($url, $title = null, $attributes = [], $secure = null)
    {
        $url = self::$url->asset($url, $secure);
        return self::link($url, $title ?: $url, $attributes, $secure);
    }
    /**
     * Generate a HTTPS HTML link to an asset.
     *
     * @param string $url
     * @param string $title
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function linkSecureAsset($url, $title = null, $attributes = [])
    {
        return self::linkAsset($url, $title, $attributes, true);
    }
    /**
     * Generate a HTML link to a named route.
     *
     * @param string $name
     * @param string $title
     * @param array  $parameters
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function linkRoute($name, $title = null, $parameters = [], $attributes = [])
    {
        return self::link(self::$url->route($name, $parameters), $title, $attributes);
    }
    /**
     * Generate a HTML link to a controller action.
     *
     * @param string $action
     * @param string $title
     * @param array  $parameters
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function linkAction($action, $title = null, $parameters = [], $attributes = [])
    {
        return self::link(self::$url->action($action, $parameters), $title, $attributes);
    }
    /**
     * Generate a HTML link to an email address.
     *
     * @param string $email
     * @param string $title
     * @param array  $attributes
     * @param bool   $escape
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function mailto($email, $title = null, $attributes = [], $escape = true)
    {
        $email = self::email_address($email);
        $title = $title ?: $email;
        if ($escape) {
            $title = self::entities($title);
        }
        $email = self::obfuscate('mailto:') . $email;
        return self::toHtmlString('<a href="' . $email . '"' . self::attributes($attributes) . '>' . $title . '</a>');
    }
    /**
     * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
     *
     * @param string $email
     *
     * @return string
     */
    public static function email_address($email)
    {
        return str_replace('@', '&#64;', self::obfuscate($email));
    }
    /**
     * Generates non-breaking space entities based on number supplied.
     *
     * @param int $num
     *
     * @return string
     */
    public function nbsp($num = 1)
    {
        return str_repeat('&nbsp;', $num);
    }
    /**
     * Generate an ordered list of items.
     *
     * @param array $list
     * @param array $attributes
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    public function ol($list, $attributes = [])
    {
        return self::listing('ol', $list, $attributes);
    }
    /**
     * Generate an un-ordered list of items.
     *
     * @param array $list
     * @param array $attributes
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    public function ul($list, $attributes = [])
    {
        return self::listing('ul', $list, $attributes);
    }
    /**
     * Generate a description list of items.
     *
     * @param array $list
     * @param array $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function dl(array $list, array $attributes = [])
    {
        $attributes = self::attributes($attributes);
        $html = "<dl{$attributes}>";
        foreach ($list as $key => $value) {
            $value = (array) $value;
            $html .= "<dt>$key</dt>";
            foreach ($value as $v_key => $v_value) {
                $html .= "<dd>$v_value</dd>";
            }
        }
        $html .= '</dl>';
        return self::toHtmlString($html);
    }
    /**
     * Create a listing HTML element.
     *
     * @param string $type
     * @param array  $list
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    protected function listing($type, $list, $attributes = [])
    {
        $html = '';
        if (count($list) == 0) {
            return $html;
        }
        // Essentially we will just spin through the list and build the list of the HTML
        // elements from the array. We will also handled nested lists in case that is
        // present in the array. Then we will build out the final listing elements.
        foreach ($list as $key => $value) {
            $html .= self::listingElement($key, $type, $value);
        }
        $attributes = self::attributes($attributes);
        return self::toHtmlString("<{$type}{$attributes}>{$html}</{$type}>");
    }
    /**
     * Create the HTML for a listing element.
     *
     * @param mixed  $key
     * @param string $type
     * @param mixed  $value
     *
     * @return string
     */
    protected function listingElement($key, $type, $value)
    {
        if (is_array($value)) {
            return self::nestedListing($key, $type, $value);
        } else {
            return '<li>' . self::escapeAll($value) . '</li>';
        }
    }
    /**
     * Create the HTML for a nested listing attribute.
     *
     * @param mixed  $key
     * @param string $type
     * @param mixed  $value
     *
     * @return string
     */
    protected function nestedListing($key, $type, $value)
    {
        if (is_int($key)) {
            return self::listing($type, $value);
        } else {
            return '<li>' . $key . self::listing($type, $value) . '</li>';
        }
    }
    /**
     * Build an HTML attribute string from an array.
     *
     * @param array $attributes
     *
     * @return string
     */
    public static function attributes($attributes)
    {
        $html = [];
        foreach ((array) $attributes as $key => $value) {
            $element = self::attributeElement($key, $value);
            if (! is_null($element)) {
                $html[] = $element;
            }
        }
        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }
    /**
     * Build a single attribute element.
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    protected static function attributeElement($key, $value)
    {
        // For numeric keys we will assume that the key and the value are the same
        // as this will convert HTML attributes such as "required" to a correct
        // form like required="required" instead of using incorrect numerics.
        if (is_numeric($key)) {
            $key = $value;
        }
        if (! is_null($value)) {
            return $key . '="' . self::escapeAll($value) . '"';
        }
    }
    /**
     * Obfuscate a string to prevent spam-bots from sniffing it.
     *
     * @param string $value
     *
     * @return string
     */
    public function obfuscate($value)
    {
        $safe = '';
        foreach (str_split($value) as $letter) {
            if (ord($letter) > 128) {
                return $letter;
            }
            // To properly obfuscate the value, we will randomly convert each letter to
            // its entity or hexadecimal representation, keeping a bot from sniffing
            // the randomly obfuscated letters out of the string on the responses.
            switch (rand(1, 3)) {
                case 1:
                    $safe .= '&#' . ord($letter) . ';';
                    break;
                case 2:
                    $safe .= '&#x' . dechex(ord($letter)) . ';';
                    break;
                case 3:
                    $safe .= $letter;
            }
        }
        return $safe;
    }
    /**
     * Generate a meta tag.
     *
     * @param string $name
     * @param string $content
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function meta($name, $content, array $attributes = [])
    {
        $defaults = compact('name', 'content');
        $attributes = array_merge($defaults, $attributes);
        return self::toHtmlString('<meta' . self::attributes($attributes) . '>' . PHP_EOL);
    }
    /**
     * Generate an html tag.
     *
     * @param string $tag
     * @param mixed $content
     * @param array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public function tag($tag, $content, array $attributes = [])
    {
        $content = is_array($content) ? implode(PHP_EOL, $content) : $content;
		
        return self::toHtmlString('<' . $tag . self::attributes($attributes) . '>' . PHP_EOL . self::toHtmlString($content) . PHP_EOL . '</' . $tag . '>' . PHP_EOL);
    }
    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected static function toHtmlString($html)
    {
        return $html;
    }
    /**
     * Dynamically handle calls to the class.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return \Illuminate\Contracts\View\View|mixed
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        try {
            return self::componentCall($method, $parameters);
        } catch (BadMethodCallException $e) {
            //
        }
        try {
            return self::macroCall($method, $parameters);
        } catch (BadMethodCallException $e) {
            //
        }
        throw new BadMethodCallException("Method {$method} does not exist.");
    }
}