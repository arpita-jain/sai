<?php
/**
 *  MoPublication plugin for WordPress
 *  http://www.mopublication.com
 *
 *  Miscellaneous extra function library
 *
 *  (c) 2012 Grenade Technologies, South Africa
 *  http://www.grenadeco.com
 */

/**
 * Convert Hex colour code to RGB colour values
 *
 * @param $colour
 * @return array|bool
 */
function hex2rgb( $colour ) {

    if ( $colour[0] == '#' ) {
            $colour = substr( $colour, 1 );
    }

    if ( strlen( $colour ) == 6 ) {
            list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    } elseif ( strlen( $colour ) == 3 ) {
            list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    } else {
            return false;
    }

    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );

    return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    //return $r.','.$g.','.$b;
}

function str_img_src($html) {
    
        if (stripos($html, '<img') !== false) {
            $imgsrc_regex = "<img.*?src=[\"'](.+?)[\"'].*?>";
            preg_match_all($imgsrc_regex, $html, $matches);
            unset($imgsrc_regex);
            unset($html);
            if (is_array($matches) && !empty($matches)) {
                return $matches;
            } else {
                return false;
            }
        } else {
            return false;
        }
        
}

function cleanContent($content, $comment = false) {
   
   //YouTube
   //$expression = '+\[youtube(.*?)\](.*?)\[\/youtube\]+';
   $expression = '#\[\s*?youtube\b[^\]]*\](.*?)\[/youtube\b[^\]]*\]#s';
   if (preg_match_all($expression, $content, $matches)) {
       
      $x = 0;
      foreach($matches[1] as $match) {

          $urlInfo = explode('v=',$match);
          
          $content = str_replace($matches[0][$x], '<iframe width="560" height="315" src="http://www.youtube.com/embed/'.$urlInfo[1].'" frameborder="0" allowfullscreen></iframe>', $content);
          
          $x++;
      } 

   }
   
   $content = trim($content);
   $content = preg_replace('|\[(.+?)\](.+?\[/\\1\])?|s', '', $content);
   $content =  nl2br ($content);

   //heart characters
   $content = str_replace("<3","&hearts;",$content);
 
   if(!$comment) {
       
       $content = trim($content);
       $content = preg_replace('#(?:<br\s*/?>\s*?){2,}#', '</p><p>', $content);
       $content = "<p>".$content."</p>";
       
   }
   
   $content = strip_tags($content,'<h1><h2><h3><h4><h5><h6><p><a><ul><ol><li><strong><b><i><em><table><tbody><tr><td><th><dl><dt><dd><blockquote><address><hr><pre><code><form><input><button><textarea><option><select><iframe>');
   $content = preg_replace('/<a href=.*?><\/a>/','',$content); 
   $content = str_replace("&nbsp;","",$content);
   
   //remove empty <p> tags
   $content = preg_replace('~<p>\s*<\/p>~i','',$content);
   
   $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
   
   return $content;
   
}

function cleanContentDemo($content) {
    
    $content = substr(strip_tags($content), 0, 65);
    $content = trim($content);
    $content = filter_var($content, FILTER_SANITIZE_STRING);
    
    $content = str_replace("&nbsp;","",$content);
    $content = html_entity_decode($content);
    $content = trim($content);
    
    return $content;
    
}

function cleanContentStrict($content) {
    
    //remove non-prinatable characters
    $content = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\xFF]/u', '', $content); 
    
    return $content;
    
}

function cleanGeneral($content) {
    
    //remove non-prinatable characters 
    //$content = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x80-\xFF]/u', '', $content);
    
    $content = trim($content);
    $content = strip_tags($content);
    $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
    
    return $content;
}

/**
 * Initialize and return tabs
 *  
 */
function getSystemTabs() {

    //System pages
    $systemPages = array();
            
    $systemPages[0]['ID']       = 'latest';
    $systemPages[0]['name'] 	= 'Latest';
    $systemPages[0]['wordID']   = 'Latest';
    $systemPages[0]['type'] 	= 'system';
    $systemPages[0]['icon'] 	= 'latest';
    
    $systemPages[1]['ID']       = 'search';
    $systemPages[1]['name'] 	= 'Search';
    $systemPages[1]['wordID']   = 'Search';
    $systemPages[1]['type'] 	= 'system';
    $systemPages[1]['icon'] 	= 'search';
    
    $systemPages[2]['ID']       = 'videos';
    $systemPages[2]['name'] 	= 'Videos';
    $systemPages[2]['wordID']   = 'Videos';
    $systemPages[2]['type'] 	= 'system';
    $systemPages[2]['icon'] 	= 'videos';
    
    $systemPages[3]['ID']       = 'audio';
    $systemPages[3]['name'] 	= 'Audio';
    $systemPages[3]['wordID']   = 'Audio';
    $systemPages[3]['type'] 	= 'system';
    $systemPages[3]['icon'] 	= 'audio';
    
    $systemPages[4]['ID']       = 'categories';
    $systemPages[4]['name'] 	= 'Categories';
    $systemPages[4]['wordID']   = 'Categories';
    $systemPages[4]['type'] 	= 'system';
    $systemPages[4]['icon'] 	= 'categories';
    
    $systemPages[5]['ID']       = 'tags';
    $systemPages[5]['name'] 	= 'Tags';
    $systemPages[5]['wordID']   = 'Tags';
    $systemPages[5]['type'] 	= 'system';
    $systemPages[5]['icon'] 	= 'tags';
    
    $systemPages[6]['ID']       = 'contact';
    $systemPages[6]['name'] 	= 'Contact';
    $systemPages[6]['wordID']   = 'Contact';
    $systemPages[6]['type'] 	= 'system';
    $systemPages[6]['icon'] 	= 'contact';
    
    $systemPages[7]['ID']       = 'about';
    $systemPages[7]['name'] 	= 'About';
    $systemPages[7]['wordID']   = 'About';
    $systemPages[7]['type'] 	= 'system';
    $systemPages[7]['icon'] 	= 'about';
    
    return $systemPages;
    
}

function addToTabsOrder($tabsArray) {
    
    $tabOrder = get_option('mopub_tabs_order');

    if(empty($tabOrder)) {
       
       $tabs = array(); 
       
       $x = 0;
       foreach($tabsArray as $tab) {

            $tabs[$x] = array('name' => $tab['name'], 'type' => $tab['type'], 'icon' => $tab['icon'], 'link' => $tab['link'], 'ID' => $tab['ID'], 'TABID' => $x);
            $x++;

        }
        update_option('mopub_tabs_order', json_encode($tabs));
       
        return $tabs;
    }

    //Get the tab order
    $tabOrder = json_decode(get_option('mopub_tabs_order'), true);
    
    foreach($tabsArray as $tab) {
    
        $key = end(array_keys($tabOrder)) + 1;

        $tabOrder[$key]['name'] = $tab['name'];
        $tabOrder[$key]['type'] = $tab['type'];
        $tabOrder[$key]['icon'] = $tab['icon'];
        $tabOrder[$key]['link'] = $tab['link'];
        $tabOrder[$key]['ID'] = $tab['ID'];
        $tabOrder[$key]['TABID'] = $key;
        
    }
    
    update_option('mopub_tabs_order', json_encode($tabOrder));
    return $tabOrder;
}

function tabInArray($needle, $haystack) {
    
    foreach ($haystack as $item) {
        
        if($item['name'] == $needle['name'] AND $item['type'] == $needle['type']) {
            
            return true;
        
        }
        
    }
    
    return false;
    
}

function removeTabFromOrder($key, $value) {
    
    $tabs = json_decode(get_option('mopub_tabs_order'), true);
    
    $newAppOrder = array();

    foreach($tabs as $tab) {
        
        if($tab[$key] != $value) {
            
            $newAppOrder[] = $tab;

        }

        
        
    }
    
    update_option('mopub_tabs_order', json_encode($newAppOrder));
    
}

function getPermalinkStructure() {
    
    $permalink_seperator = '';
    
    if ( get_option('permalink_structure') )
    {
        $permalink_seperator = '?';
    }
    else
    {
        $permalink_seperator = '&';
    }

    $page = get_page_by_title('mopubxml');

    $pagelink = get_permalink($page->ID);
    
    return $pagelink .$permalink_seperator;
    
}