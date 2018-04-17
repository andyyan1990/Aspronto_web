<?php
/**
 * Configuration file for google font array and websafe font array
 * 
 * @package Windflaw
 * @link    http://www.loftocean.com/
 * @author	Suihai Huang from Loft Ocean Team
 * @since version 1.0
 */

$windflaw_fontString  = "Abel,Actor,Andada,Cantata One,Halant,Istok Web,Karma,Kdam Thmor,Lato,Ledger,Lora,Marvel,Nobile,Oxygen Mono,Poly,Quicksand,Raleway,Trykker,Unna,Volkhov";
$windflaw_fontArray   = explode(",", $windflaw_fontString);
$windflaw_googleFonts = array();
foreach($windflaw_fontArray as $font){
	$windflaw_googleFonts[$font] = $font;
}

$windflaw_webSafeFonts = array(
	"Georgia, serif" => 'Georgia',
	"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => 'Palatino Linotype',
	"'Times New Roman', Times, serif" => 'Times New Roman',
	"Arial, Helvetica, sans-serif" => 'Arial',
	"'Arial Black', Gadget, sans-serif" => 'Arial Black',
	"'Comic Sans MS', cursive, sans-serif" => 'Comic Sans MS',
	"Impact, Charcoal, sans-serif" => 'Impact',
	"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => 'Lucida Sans Unicode',
	"Tahoma, Geneva, sans-serif" => 'Tahoma',
	"'Trebuchet MS', Helvetica, sans-serif" => 'Trebuchet MS',
	"Verdana, Geneva, sans-serif" => 'Verdana, Geneva',
	"'Courier New', Courier, monospace" => 'Courier New',
	"'Lucida Console', Monaco, monospace" => 'Lucida Console'
);
?>