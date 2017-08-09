<?php

namespace SONFin\Model;

Interface UserInterface
{
	public function getId();
	public function getFullName();
	public function getEmail();
	public function getPassword();
}