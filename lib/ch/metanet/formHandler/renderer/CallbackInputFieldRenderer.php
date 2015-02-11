<?php

namespace ch\metanet\formHandler\renderer;

use ch\metanet\formHandler\field\InputField;

/**
 * @author Pascal Muenst <entwicklung@metanet.ch>
 * @copyright Copyright (c) 2014, METANET AG
 */
class CallbackInputFieldRenderer extends InputFieldRenderer
{
	protected $callback;

	/**
	 * @param array $callback A valid callback to render the InputField
	 */
	public function __construct(array $callback)
	{
		$this->callback = $callback;
	}

	/**
	 * @param InputField $field The InputField to render
	 * @return string The rendered HTML for the InputField
	 */
	public function render(InputField $field)
	{
		return call_user_func($this->callback, $field);
	}
}

/* EOF */