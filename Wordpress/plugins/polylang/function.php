<?php
/******************************************/
/***** Customize Language Switcher********/
/******************************************/
function bioinnovation_polylang_languages( $class = '' ) {
   if ( ! function_exists( 'pll_the_languages' ) ) return;
   // Gets the pll_the_languages() raw code
   $languages = pll_the_languages( array(
     'display_names_as'       => 'slug',
     'hide_if_no_translation' => 1,
     'raw'                    => true
   ) );
   $output = '';
   // Checks if the $languages is not empty
   if ( ! empty( $languages ) ) {

     // Runs the loop through all languages
     foreach ( $languages as $language ) {
       // Variables containing language data
       $id             = $language['id'];
       $slug           = $language['slug'];
       $url            = $language['url'];
       $current        = $language['current_lang'] ? ' languages__item--current' : '';
       $no_translation = $language['no_translation'];
       // Checks if the page has translation in this language
       if ( ! $no_translation ) {
         // Check if it's current language
         if ( $current ) {
					 $output .= '<button class="btn pt-1 pb-1 pl-2 rounded-0 pr-2 text-white bg-primary disabled">'.$slug.'</button>';
           // Output the language in a <span> tag so it's not clickable
           //$output .= "<span class=\"languages__item$current\">$slug</span>";
         } else {
					 $output .= '<a href="'.$url.'" class="btn pt-1 pb-1 pl-2 pr-2 rounded-0 text-white bgg-light" >'.$slug.'</a>';
           // Output the language in an anchor tag
           //$output .= "<a href=\"$url\" class=\"languages__item$current\">$slug</a>";
         }
       }
     }
   }
   return $output;
 }