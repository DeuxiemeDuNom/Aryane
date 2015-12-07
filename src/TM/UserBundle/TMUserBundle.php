<?php

namespace TM\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class TMUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
