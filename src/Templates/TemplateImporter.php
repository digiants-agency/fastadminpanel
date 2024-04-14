<?php

namespace Digiants\FastAdminPanel\Templates;

class TemplateImporter
{
	const DEFAULT 		= 'Default';
	const COMPONENTS	= 'With components';

	public function __construct(
		protected TemplateComponents $templateComponents,
		protected TemplateDefault $templateDefault,
	) { }

    public function import($template)
	{
		if ($template == self::DEFAULT) {

			$this->templateDefault->import();

		} else {

			$this->templateComponents->import();
		}
	}
}