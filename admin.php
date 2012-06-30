<?php

/**
 * Back-End of Syntaxhighlighter_XH.
 *
 * Copyright (c) 2012 Christoph M. Becker (see license.txt)
 */


if (!defined('CMSIMPLE_XH_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}


/**
 * Returns the plugin version information view.
 *
 * @return string  The (X)HTML.
 */
function Syntaxhighlighter_version()
{
    global $pth;

    return '<h1><a href="http://3-magi.net/?CMSimple_XH/Syntaxhighlighter_XH">Syntaxhighlighter_XH</a></h1>'."\n"
	. tag('img src="'.$pth['folder']['plugins'].'syntaxhighlighter/syntaxhighlighter.png" class="syntaxhighlighter_plugin_icon"')
	. '<p>Version: '.SYNTAXHIGHLIGHTER_VERSION.'</p>'."\n"
	. '<p>Copyright &copy; 2012 <a href="http://3-magi.net">Christoph M. Becker</a></p>'."\n"
	. '<p>Powered by <a href="http://alexgorbatchev.com/SyntaxHighlighter/">SyntaxHighlighter</a></p>'
	. '<p class="syntaxhighlighter_license">'
	. 'This program is free software: you can redistribute it and/or modify'
	. ' it under the terms of the GNU General Public License as published by'
	. ' the Free Software Foundation, either version 3 of the License, or'
	. ' (at your option) any later version.</p>'."\n"
	. '<p class="syntaxhighlighter_license">'
	. 'This program is distributed in the hope that it will be useful,'
	. ' but WITHOUT ANY WARRANTY; without even the implied warranty of'
	. ' MERCHAN&shy;TABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the'
	. ' GNU General Public License for more details.</p>'."\n"
	. '<p class="syntaxhighlighter_license">'
	. 'You should have received a copy of the GNU General Public License'
	. ' along with this program.  If not, see'
	. ' <a href="http://www.gnu.org/licenses/">http://www.gnu.org/licenses/</a>.</p>'."\n";
}


/**
 * Returns the requirements information view.
 *
 * @return string  The (X)HTML.
 */
function Syntaxhighlighter_systemCheck()
{ // RELEASE-TODO
    global $pth, $tx, $plugin_tx;

    define('SYNTAXHIGHLIGHTER_PHP_VERSION', '4.3.0');
    $ptx = $plugin_tx['syntaxhighlighter'];
    $imgdir = $pth['folder']['plugins'].'syntaxhighlighter/images/';
    $ok = tag('img src="'.$imgdir.'ok.png" alt="ok"');
    $warn = tag('img src="'.$imgdir.'warn.png" alt="warning"');
    $fail = tag('img src="'.$imgdir.'fail.png" alt="failure"');
    $o = '<h4>'.$ptx['syscheck_title'].'</h4>'
	    .(version_compare(PHP_VERSION, SYNTAXHIGHLIGHTER_PHP_VERSION) >= 0 ? $ok : $fail)
	    .'&nbsp;&nbsp;'.sprintf($ptx['syscheck_phpversion'], SYNTAXHIGHLIGHTER_PHP_VERSION)
	    .tag('br')."\n";
    foreach (array('date', 'pcre', 'session') as $ext) {
	$o .= (extension_loaded($ext) ? $ok : $fail)
		.'&nbsp;&nbsp;'.sprintf($ptx['syscheck_extension'], $ext).tag('br')."\n";
    }
    $o .= (!get_magic_quotes_runtime() ? $ok : $fail)
	    .'&nbsp;&nbsp;'.$ptx['syscheck_magic_quotes'].tag('br').tag('br')."\n";
    $o .= (strtoupper($tx['meta']['codepage']) == 'UTF-8' ? $ok : $fail)
	    .'&nbsp;&nbsp;'.$ptx['syscheck_encoding'].tag('br')."\n";
    $o .= (file_exists($pth['folder']['plugins'].'jquery/jquery.inc.php') ? $ok : $fail)
	    .'&nbsp;&nbsp;'.$ptx['syscheck_jquery'].tag('br').tag('br')."\n";
    $folders = array();
    foreach (array('config/', 'css/', 'languages/') as $folder) {
	$folders[] = $pth['folder']['plugins'].'syntaxhighlighter/'.$folder;
    }
    foreach ($folders as $folder) {
	$o .= (is_writable($folder) ? $ok : $warn)
		.'&nbsp;&nbsp;'.sprintf($ptx['syscheck_writable'], $folder).tag('br')."\n";
    }
    return $o;
}


/*
 * Handle the plugin administration.
 */
if (isset($syntaxhighlighter) && $syntaxhighlighter == 'true') {
    $o .= print_plugin_admin('off');
    switch ($admin) {
    case '':
	$o .= Syntaxhighlighter_version() . tag('hr') . Syntaxhighlighter_systemCheck();
	break;
    default:
	$o .= plugin_admin_common($action, $admin, $plugin);
    }
}

?>