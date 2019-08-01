<?php


require_once("htmlBuilder.php");
class Form extends HtmlBuilder
{
    	
	/**
     * The HTML builder instance.
     *
     * @var \Collective\Html\HtmlBuilder
     */
    protected static $html;

    /**
     * The URL generator instance.
     *
     * @var \Illuminate\Contracts\Routing\UrlGenerator
     */
    protected static $url;

    /**
     * The View factory instance.
     *
     * @var \Illuminate\Contracts\View\Factory
     */
    protected static $view;

    /**
     * The CSRF token used by the form builder.
     *
     * @var string
     */
    protected static $csrfToken;

    /**
     * The session store implementation.
     *
     * @var \Illuminate\Contracts\Session\Session
     */
    protected static $session;

    /**
     * The current model instance for the form.
     *
     * @var mixed
     */
    protected static $model;

    /**
     * An array of label names we've created.
     *
     * @var array
     */
    protected static $labels = [];

    /**
     * The reserved form open attributes.
     *
     * @var array
     */
    protected static $reserved = ['method', 'url', 'route', 'action', 'files'];

    /**
     * The form methods that should be spoofed, in uppercase.
     *
     * @var array
     */
    protected static $spoofedMethods = ['DELETE', 'PATCH', 'PUT'];

    /**
     * The types of inputs to not fill values on by default.
     *
     * @var array
     */
    protected static $skipValueTypes = ['file', 'password', 'checkbox', 'radio'];

    /**
     * Create a new form builder instance.
     *
     * @param  \Collective\Html\HtmlBuilder               $html
     * @param  \Illuminate\Contracts\Routing\UrlGenerator $url
     * @param  \Illuminate\Contracts\View\Factory         $view
     * @param  string                                     $csrfToken
     */
	 
	
    protected static $draw = false;
	
    public function __construct(HtmlBuilder $html, UrlGenerator $url, Factory $view, $csrfToken)
    {
         $this->url = $url;
        $this->html = $html;
        $this->view = $view;
        $this->csrfToken = $csrfToken;
    }

    public static function redraw($set = true) {
		self::$draw = $set;
	}
    /**
     * Open up a new HTML form.
     *
     * @param  array $options
     *
     * @return \Illuminate\Support\HtmlString
     */
	 
    public static function open(array $options = [], $validate = false)
    {
        $method = array_get($options, 'method', 'post');

        // We need to extract the proper method from the attributes. If the method is
        // something other than GET or POST we'll use POST since we will spoof the
        // actual method since forms don't support the reserved methods in HTML.
        $attributes['method'] = self::getMethod($method);

        $attributes['action'] = self::getAction($options);

        $attributes['accept-charset'] = 'UTF-8';
		
		if($validate) {			
			$attributes['validation'] = 'true';
		}

        // If the method is PUT, PATCH or DELETE we will need to add a spoofer hidden
        // field that will instruct the Symfony request to pretend the method is a
        // different method than it actually is, for convenience from the forms.
        $append = self::getAppendage($method);

        if (isset($options['files']) && $options['files']) {
            $options['enctype'] = 'multipart/form-data';
        }

        // Finally we're ready to create the final form HTML field. We will attribute
        // format the array of attributes. We will also add on the appendage which
        // is used to spoof requests for this PUT, PATCH, etc. methods on forms.
        $attributes = array_merge(

          $attributes, array_except($options, self::$reserved)

        );

        // Finally, we will concatenate all of the attributes into a single string so
        // we can build out the final form open statement. We'll also append on an
        // extra value for the hidden _method field if it's needed for the form.
        $attributes = self::attributes($attributes);

        return self::toHtmlString('<form' . $attributes . '>' . $append);
    }

    /**
     * Create a new model based form builder.
     *
     * @param  mixed $model
     * @param  array $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function model($model, array $options = [])
    {
        self::$model = $model;

        return self::open($options);
    }

    /**
     * Set the model instance on the form builder.
     *
     * @param  mixed $model
     *
     * @return void
     */
    public static function setModel($model)
    {
        self::$model = $model;
    }

    /**
     * Close the current form.
     *
     * @return string
     */
    public static function close()
    {
        self::$labels = [];

        self::$model = null;

        return self::toHtmlString('</form>');
    }

    /**
     * Generate a hidden field with the current CSRF token.
     *
     * @return string
     */
    public static function token()
    {
		$time = sha1(time());
        $token = ! empty(self::$csrfToken) ? self::$csrfToken : USER_TOKEN;

        return self::hidden('_token', $token);
    }

    /**
     * Create a form label element.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     * @param  bool   $escape_html
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function label($name, $value = null, $options = [], $escape_html = true)
    {
        self::$labels[] = $name;

        $options = self::attributes($options);

        $value = self::formatLabel($name, $value);

        if ($escape_html) {
            $value = self::entities($value);
        }

        return self::toHtmlString('<label for="' . $name . '"' . $options . '>' . $value . '</label>');
    }

    /**
     * Format the label value.
     *
     * @param  string      $name
     * @param  string|null $value
     *
     * @return string
     */
    protected static function formatLabel($name, $value)
    {
        return $value ?: ucwords(str_replace('_', ' ', $name));
    }

    /**
     * Create a form input field.
     *
     * @param  string $type
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function input($type, $name, $value = null, $options = [], $label = null)
    {
       
        if (!isset($options['name'])) {
            if(!$options)
                $options = [];
            $options['name'] = $name;
        }

        // We will get the appropriate value for the given field. We will look for the
        // value in the session for the value in the old input data then we'll look
        // in the model instance if one is set. Otherwise we will just use empty.
        $id = self::getIdAttribute($name, $options);

        if (! in_array($type, self::$skipValueTypes)) {
            $value = self::getValueAttribute($name, $value);
        }
		
        if($type !== 'radio')
		if(self::$draw) {
			if(Input::post($name) AND empty($value)) 
				$value = Input::post($name);
		}
		else{
			if(self::$model AND isset(self::$model[$name]))
				$value = self::$model[$name];
		}
        // Once we have the type, value, and ID we can merge them into the rest of the
        // attributes array so we can convert them into their HTML attribute format
        // when creating the HTML element. Then, we will return the entire input.
        $merge = compact('type', 'value', 'id');

        $options = array_merge($options, $merge);

        if($label)        
            return self::toHtmlString('<span class="radio-span"><input' . self::attributes($options) . '>'. $label .'</span>');
        else
            return self::toHtmlString('<input' . self::attributes($options) . '>');
    }

    /**
     * Create a text input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function text($name, $value = null, $options = [])
    {
        return self::input('text', $name, $value, $options);
    }

    /**
     * Create a password input field.
     *
     * @param  string $name
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function password($name, $options = [])
    {
        return self::input('password', $name, '', $options);
    }

    /**
     * Create a hidden input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function hidden($name, $value = null, $options = [])
    {
        return self::input('hidden', $name, $value, $options);
    }

    /**
     * Create an e-mail input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function email($name, $value = null, $options = [])
    {
        return self::input('email', $name, $value, $options);
    }

    /**
     * Create a tel input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function tel($name, $value = null, $options = [])
    {
        return self::input('tel', $name, $value, $options);
    }

    /**
     * Create a number input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function number($name, $value = null, $options = [])
    {
        return self::input('number', $name, $value, $options);
    }

    /**
     * Create a date input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function date($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d');
        }

        return self::input('date', $name, $value, $options);
    }

    /**
     * Create a datetime input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function datetime($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format(DateTime::$RFC3339);
        }

        return self::input('datetime', $name, $value, $options);
    }

    /**
     * Create a datetime-local input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function datetimeLocal($name, $value = null, $options = [])
    {
        if ($value instanceof DateTime) {
            $value = $value->format('Y-m-d\TH:i');
        }

        return self::input('datetime-local', $name, $value, $options);
    }

    /**
     * Create a time input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function time($name, $value = null, $options = [])
    {
        return self::input('time', $name, $value, $options);
    }

    /**
     * Create a url input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function url($name, $value = null, $options = [])
    {
        return self::input('url', $name, $value, $options);
    }

    /**
     * Create a file input field.
     *
     * @param  string $name
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function file($name, $options = [])
    {
        return self::input('file', $name, null, $options);
    }

    /**
     * Create a textarea input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function textarea($name, $value = null, $options = [])
    {
        if (! isset($options['name'])) {
            $options['name'] = $name;
        }

			
        // Next we will look for the rows and cols attributes, as each of these are put
        // on the textarea element definition. If they are not present, we will just
        // assume some sane default values for these attributes for the developer.
        $options = self::setTextAreaSize($options);

        $options['id'] = self::getIdAttribute($name, $options);

			
        $value = (string) self::getValueAttribute($name, $value);

		if(self::$draw) {
			if(Input::post($name) AND empty($value)) 
				$value = Input::post($name);
		}
		else{
			if(self::$model AND isset(self::$model[$name]))
				$value = self::$model[$name];
		}	
        unset($options['size']);

        // Next we will convert the attributes into a string form. Also we have removed
        // the size attribute, as it was merely a short-cut for the rows and cols on
        // the element. Then we'll create the final textarea elements HTML for us.
        $options = self::attributes($options);

        return self::toHtmlString('<textarea' . $options . '>' . self::escapeAll($value). '</textarea>');
    }

    /**
     * Set the text area size on the attributes.
     *
     * @param  array $options
     *
     * @return array
     */
    protected static function setTextAreaSize($options)
    {
        if (isset($options['size'])) {
            return self::setQuickTextAreaSize($options);
        }

        // If the "size" attribute was not specified, we will just look for the regular
        // columns and rows attributes, using sane defaults if these do not exist on
        // the attributes array. We'll then return this entire options array back.
        $cols = array_get($options, 'cols', 50);

        $rows = array_get($options, 'rows', 10);

        return array_merge($options, compact('cols', 'rows'));
    }

    /**
     * Set the text area size using the quick "size" attribute.
     *
     * @param  array $options
     *
     * @return array
     */
    protected static function setQuickTextAreaSize($options)
    {
        $segments = explode('x', $options['size']);

        return array_merge($options, ['cols' => $segments[0], 'rows' => $segments[1]]);
    }

    /**
     * Create a select box field.
     *
     * @param  string $name
     * @param  array  $list
     * @param  string $selected
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function select($name, $list = [], $selected = null, $options = [], $holder = null)
    {
        // When building a select box the "value" attribute is really the selected one
        // so we will use that when checking the model or session for a value which
        // should provide a convenient method of re-populating the forms on post.
		
		
	
	
        $selected = self::getValueAttribute($name, $selected);

        $options['id'] = self::getIdAttribute($name, $options);

        if (! isset($options['name'])) {
            $options['name'] = $name;
        }

        // We will simply loop through the options and build an HTML value for each of
        // them until we have an array of HTML declarations. Then we will join them
        // all together into one single HTML element that can be put on the form.
        $html = [];
		
		if(self::$draw) {
			if(Input::post($name) AND empty($value)) 
				$selected = Input::post($name);	
		}		
		else{
			if(self::$model AND isset(self::$model[$name]))
				$selected = self::$model[$name];
		}	

        if (isset($options['placeholder'])) {
            $html[] = self::placeholderOption($options['placeholder'], $selected);
            unset($options['placeholder']);
        }

        foreach ($list as $value => $display) {			
            $html[] = self::getSelectOption($display, $value, $selected);
        }
	
        // Once we have all of this HTML, we can join this into a single element after
        // formatting the attributes into an HTML "attributes" string, then we will
        // build out a final select statement, which will contain all the values.
        $options = self::attributes($options);

        $list = implode('', $html);

        if($holder) {
            $holder = "<option disabled selected value=''>$holder</option>";
            $list = $holder . $list ;
        }
        return self::toHtmlString("<select{$options}>{$list}</select>");
    }

    /**
     * Create a select range field.
     *
     * @param  string $name
     * @param  string $begin
     * @param  string $end
     * @param  string $selected
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function selectRange($name, $begin, $end, $selected = null, $options = [])
    {
        $range = array_combine($range = range($begin, $end), $range);

        return self::$select($name, $range, $selected, $options);
    }

    /**
     * Create a select year field.
     *
     * @param  string $name
     * @param  string $begin
     * @param  string $end
     * @param  string $selected
     * @param  array  $options
     *
     * @return mixed
     */
    public static function selectYear()
    {
        return call_user_func_array([$this, 'selectRange'], func_get_args());
    }

    /**
     * Create a select month field.
     *
     * @param  string $name
     * @param  string $selected
     * @param  array  $options
     * @param  string $format
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function selectMonth($name, $selected = null, $options = [], $format = '%B')
    {
        $months = [];

        foreach (range(1, 12) as $month) {
            $months[$month] = strftime($format, mktime(0, 0, 0, $month, 1));
        }

        return self::$select($name, $months, $selected, $options);
    }

    /**
     * Get the select option for the given value.
     *
     * @param  string $display
     * @param  string $value
     * @param  string $selected
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function getSelectOption($display, $value, $selected)
    {
        if (is_array($display)) {
            return self::optionGroup($display, $value, $selected);
        }

        return self::option($display, $value, $selected);
    }

    /**
     * Create an option group form element.
     *
     * @param  array  $list
     * @param  string $label
     * @param  string $selected
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected function optionGroup($list, $label, $selected)
    {
        $html = [];

        foreach ($list as $value => $display) {
            $html[] = self::option($display, $value, $selected);
        }

        return self::toHtmlString('<optgroup label="' . self::escapeAll($label) . '">' . implode('', $html) . '</optgroup>');
    }

    /**
     * Create a select element option.
     *
     * @param  string $display
     * @param  string $value
     * @param  string $selected
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected static function option($display, $value, $selected)
    {
        $attr = self::getInbetweenStrings("{", "}" , $display);
        $display = str_replace(["{","}", $attr], "" ,$display);

        $selected = self::getSelectedValue($value, $selected);

        $options = ['value' => $value, 'selected' => $selected];

        return self::toHtmlString("<option $attr" . self::attributes($options) . '>' . self::escapeAll($display) . '</option>');
    }

    /**
     * Create a placeholder select element option.
     *
     * @param $display
     * @param $selected
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected function placeholderOption($display, $selected)
    {
        $selected = self::getSelectedValue(null, $selected);

        $options = compact('selected');
        $options['value'] = '';

        return self::toHtmlString('<options' . self::attributes($options) . '>' . self::escapeAll($display) . '</option>');
    }

    /**
     * Determine if the value is selected.
     *
     * @param  string $value
     * @param  string $selected
     *
     * @return null|string
     */
    protected static function getSelectedValue($value, $selected)
    {
        if (is_array($selected)) {
            return in_array($value, $selected) ? 'selected' : null;
        }

        return ((string) $value == (string) $selected) ? 'selected' : null;
    }

    /**
     * Create a checkbox input field.
     *
     * @param  string $name
     * @param  mixed  $value
     * @param  bool   $checked
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function checkbox($name, $value = 1, $checked = null, $options = [], $label = null)
    {
        if (!$value)  $value = 1;      

        if(isset(self::$model[$name])) {
            $val = self::$model[$name] ;
            if($val == 1) $checked = 'checked';            
        }
        
        if ($checked)  $checked = 'checked';  
        $options = self::attributes($options);
        
        return self::toHtmlString("<label class='for-checkbox'><input type='checkbox' value='$value' name='$name' {$options}  $checked> $label </label>");
    }

    /**
     * Create a radio button input field.
     *
     * @param  string $name
     * @param  mixed  $value
     * @param  bool   $checked
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function radio($name, $value = null, $checked = null, $options = [], $label = null)
    {
        if (is_null($value)) {
            $value = $name;
        }
        return self::checkable('radio', $name, $value, $checked, $options, $label);
    }

    /**
     * Create a checkable input field.
     *
     * @param  string $type
     * @param  string $name
     * @param  mixed  $value
     * @param  bool   $checked
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    protected static function checkable($type, $name, $value, $checked, $options= [], $label = null)
    {
        $checked = self::getCheckedState($type, $name, $value, $checked);


        print_r($options);
        if ($checked) {
            if(!isset($options['checked'])) 
                $options = [];
            $options['checked'] = 'checked';
        }

        return self::input($type, $name, $value, $options, $label);
    }

    /**
     * Get the check state for a checkable input.
     *
     * @param  string $type
     * @param  string $name
     * @param  mixed  $value
     * @param  bool   $checked
     *
     * @return bool
     */
    protected static function getCheckedState($type, $name, $value, $checked)
    {
        switch ($type) {
            case 'checkbox':
                return self::getCheckboxCheckedState($name, $value, $checked);

            case 'radio':
                return self::getRadioCheckedState($name, $value, $checked);

            default:
                return self::getValueAttribute($name) == $value;
        }
    }

    /**
     * Get the check state for a checkbox input.
     *
     * @param  string $name
     * @param  mixed  $value
     * @param  bool   $checked
     *
     * @return bool
     */
    protected function getCheckboxCheckedState($name, $value, $checked)
    {
        if (isset(self::$session) && ! self::oldInputIsEmpty() && is_null(self::$old($name))) {
            return false;
        }

        if (self::missingOldAndModel($name)) {
            return $checked;
        }

        $posted = self::getValueAttribute($name, $checked);

        if (is_array($posted)) {
            return in_array($value, $posted);
        } elseif ($posted instanceof Collection) {
            return $posted->contains('id', $value);
        } else {
            return (bool) $posted;
        }
    }

    /**
     * Get the check state for a radio input.
     *
     * @param  string $name
     * @param  mixed  $value
     * @param  bool   $checked
     *
     * @return bool
     */
    protected static function getRadioCheckedState($name, $value, $checked)
    {
        if (self::missingOldAndModel($name)) {
            return $checked;
        }

        return self::getValueAttribute($name) == $value;
    }

    /**
     * Determine if old input or model input exists for a key.
     *
     * @param  string $name
     *
     * @return bool
     */
    protected static function missingOldAndModel($name)
    {
        return (is_null(self::old($name)) && is_null(self::getModelValueAttribute($name)));
    }

    /**
     * Create a HTML reset input element.
     *
     * @param  string $value
     * @param  array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function reset($value, $attributes = [])
    {
        return self::input('reset', null, $value, $attributes);
    }

    /**
     * Create a HTML image input element.
     *
     * @param  string $url
     * @param  string $name
     * @param  array  $attributes
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function image($url, $name = null, $attributes = [])
    {
        $attributes['src'] = self::$url->asset($url);

        return self::input('image', $name, null, $attributes);
    }

    /**
     * Create a color input field.
     *
     * @param  string $name
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function color($name, $value = null, $options = [])
    {
        return self::input('color', $name, $value, $options);
    }

    /**
     * Create a submit button element.
     *
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function submit($value = null, $options = [])
    {
        return self::input('submit', null, $value, $options);
    }

    /**
     * Create a button element.
     *
     * @param  string $value
     * @param  array  $options
     *
     * @return \Illuminate\Support\HtmlString
     */
    public static function button($value = null, $options = [])
    {
        if (! array_key_exists('type', $options)) {
            $options['type'] = 'button';
        }

        return self::toHtmlString('<button' . self::attributes($options) . '>' . $value . '</button>');
    }

    /**
     * Parse the form action method.
     *
     * @param  string $method
     *
     * @return string
     */
    protected static function getMethod($method)
    {
        $method = strtoupper($method);

        return $method != 'GET' ? 'POST' : $method;
    }

    /**
     * Get the form action from the options.
     *
     * @param  array $options
     *
     * @return string
     */
    protected static function getAction(array $options)
    {
        // We will also check for a "route" or "action" parameter on the array so that
        // developers can easily specify a route or controller action when creating
        // a form providing a convenient interface for creating the form actions.
        if (isset($options['url'])) {
            return self::getUrlAction($options['url']);
        }

        if (isset($options['route'])) {
            return self::getRouteAction($options['route']);
        }

        // If an action is available, we are attempting to open a form to a controller
        // action route. So, we will use the URL generator to get the path to these
        // actions and return them from the method. Otherwise, we'll use current.
        elseif (isset($options['action'])) {
            return self::getControllerAction($options['action']);
        }

        return self::$url->current();
    }

    /**
     * Get the action for a "url" option.
     *
     * @param  array|string $options
     *
     * @return string
     */
    protected static function getUrlAction($options)
    {
        return "";
    }

    /**
     * Get the action for a "route" option.
     *
     * @param  array|string $options
     *
     * @return string
     */
    protected function getRouteAction($options)
    {
        return self::$url;
    }

    /**
     * Get the action for an "action" option.
     *
     * @param  array|string $options
     *
     * @return string
     */
    protected static function getControllerAction($options)
    {
        if (is_array($options)) {
            return self::$url->action($options[0], array_slice($options, 1));
        }

        return self::$url->action($options);
    }

    /**
     * Get the form appendage for the given method.
     *
     * @param  string $method
     *
     * @return string
     */

    protected static function getAppendage($method)
    {
        list($method, $appendage) = [strtoupper($method), ''];

        // If the HTTP method is in this list of spoofed methods, we will attach the
        // method spoofer hidden input to the form. This allows us to use regular
        // form to initiate PUT and DELETE requests in addition to the typical.

        if (in_array($method, self::$spoofedMethods)) {
            $appendage .= self::hidden('_method', $method);
        }

        // If the method is something other than GET we will go ahead and attach the
        // CSRF token to the form, as this can't hurt and is convenient to simply
        // always have available on every form the developers creates for them.
        if ($method != 'GET') {
            $appendage .= self::token();
        }

        return $appendage;
    }

    /**
     * Get the ID attribute for a field name.
     *
     * @param  string $name
     * @param  array  $attributes
     *
     * @return string
     */
    public static function getIdAttribute($name, $attributes)
    {
        if (array_key_exists('id', $attributes)) {
            return $attributes['id'];
        }

        if (in_array($name, self::$labels)) {
            return $name;
        }
    }

    /**
     * Get the value that should be assigned to the field.
     *
     * @param  string $name
     * @param  string $value
     *
     * @return mixed
     */
    public static function getValueAttribute($name, $value = null)
    {
        if (is_null($name)) {
            return $value;
        }

        if (! is_null(self::old($name)) && $name != '_method') {
            return self::old($name);
        }

        if (! is_null($value)) {
            return $value;
        }

        if (isset(self::$model)) {
            return self::getModelValueAttribute($name);
        }
    }

    /**
     * Get the model value that should be assigned to the field.
     *
     * @param  string $name
     *
     * @return mixed
     */
    protected static function getModelValueAttribute($name)
    {
        if (method_exists(self::$model, 'getFormValue')) {
            return self::$model->getFormValue(self::transformKey($name));
        }

        return data_get(self::$model, self::transformKey($name));
    }

    /**
     * Get a value from the session's old input.
     *
     * @param  string $name
     *
     * @return mixed
     */
    public static function old($name)
    {
        if (isset(self::$session)) {
            return self::$session->getOldInput(self::$transformKey($name));
        }
    }

    /**
     * Determine if the old input is empty.
     *
     * @return bool
     */
    public static function oldInputIsEmpty()
    {
        return (isset(self::$session) && count(self::$session->getOldInput()) == 0);
    }

    /**
     * Transform key from array to dot syntax.
     *
     * @param  string $key
     *
     * @return mixed
     */
    protected static function transformKey($key)
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }

    /**
     * Transform the string to an Html serializable object
     *
     * @param $html
     *
     * @return \Illuminate\Support\HtmlString
     */
   

    /**
     * Get the session store implementation.
     *
     * @return  \Illuminate\Contracts\Session\Session  $session
     */
    public static function getSessionStore()
    {
        return self::$session;
    }

    /**
     * Set the session store implementation.
     *
     * @param  \Illuminate\Contracts\Session\Session $session
     *
     * @return $this
     */
    public static function setSessionStore(Session $session)
    {
        self::$session = $session;

        return $this;
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

    public static function getInbetweenStrings($start, $end, $string){
        if (strpos($string, $start)) { // required if $start not exist in $string
            $startCharCount = strpos($string, $start) + strlen($start);
            $firstSubStr = substr($string, $startCharCount, strlen($string));
            $endCharCount = strpos($firstSubStr, $end);
            if ($endCharCount == 0) {
                $endCharCount = strlen($firstSubStr);
            }
            return substr($firstSubStr, 0, $endCharCount);
        } else {
            return '';
        }
    }

    public function __call($method, $parameters)
    {
        try {
            return self::$componentCall($method, $parameters);
        } catch (BadMethodCallException $e) {
            //
        }

        try {
            return self::$macroCall($method, $parameters);
        } catch (BadMethodCallException $e) {
            //
        }

        throw new BadMethodCallException("Method {$method} does not exist.");
    }
}