<?php

$app->on('admin.init', function() use($app){
    
    $this->helper('admin')->addAssets('modulelink:assets/components/field-module-link.tag');
    
    $this->bindClass('ModuleLink\\Controller\\Admin', 'modulelink');
    
});