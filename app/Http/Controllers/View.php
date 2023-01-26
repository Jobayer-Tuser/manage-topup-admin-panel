<?php
namespace App\Http\Controllers;

# VIEW CLASS
class View
{
	public function loadContent($directory, $page_name): void
    {
		include("resources/views/".$directory."/".$page_name.".php");
	}
}