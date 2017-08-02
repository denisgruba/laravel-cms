{{-- A simple method to style your own phpinfo() output.

<style type="text/css">
#phpinfo {}
#phpinfo pre {}
#phpinfo a:link {}
#phpinfo a:hover {}
#phpinfo table {}
#phpinfo .center {}
#phpinfo .center table {}
#phpinfo .center th {}
#phpinfo td, th {}
#phpinfo h1 {}
#phpinfo h2 {}
#phpinfo .p {}
#phpinfo .e {}
#phpinfo .h {}
#phpinfo .v {}
#phpinfo .vr {}
#phpinfo img {}
#phpinfo hr {}
</style>

<div id="phpinfo">
<?php

ob_start () ;
phpinfo () ;
$pinfo = ob_get_contents () ;
ob_end_clean () ;

// the name attribute "module_Zend Optimizer" of an anker-tag is not xhtml valide, so replace it with "module_Zend_Optimizer"
echo ( str_replace ( "module_Zend Optimizer", "module_Zend_Optimizer", preg_replace ( '%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo ) ) ) ;

?>
</div> --}}
<?php
if (!extension_loaded('imagick'))
{
    echo 'imagick not installed';
}
else
{
    echo 'imagick installed';
}
 ?>
