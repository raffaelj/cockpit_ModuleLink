<?php

$app->on('admin.init', function() use($app){
    
    $this->helper('admin')->addAssets(__DIR__.'/assets/component.js');
    $this->helper('admin')->addAssets(__DIR__.'/assets/components/field-module-link.tag');
    
    $this->bindClass('ModuleLink\\Controller\\Admin', 'modulelink');
    
});