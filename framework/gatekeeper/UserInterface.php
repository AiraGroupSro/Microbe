<?php

namespace AiraGroupSro\Microbe\framework\gatekeeper;

interface UserInterface
{
	function getRole();
	function setRole($role);
}
