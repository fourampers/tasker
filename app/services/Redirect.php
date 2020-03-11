<?php


namespace App\Services;


class Redirect
{
    public static function to(string $path = null): void
    {
		if ($path) {
			header('Location: ' . $path);
			exit();
		}
	}
}