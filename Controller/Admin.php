<?php

namespace ModuleLink\Controller;

class Admin extends \Cockpit\AuthController {

    public function index() {

        return $this->render('modulelink:views/index.php', compact('modules'));

    }

    public function get($module = null) {

        if (!$module)
            $module  = $this->app->param('module');

        $options = $this->app->param('options');

        $filters = false;
        if (isset($options['filter'])) {
            $filters = $options['filter'];
        }

        $group = $this->app->module('cockpit')->getGroup();

        // forms don't have much acls...
        if ($module == 'forms') {

            $_module = $this->module('forms')->forms();

        } else {

            $command = 'get' . ucfirst($module) . 'InGroup';

            $_module = $this->module($module)->$command($group);

        }

        return $filters === false ? $_module : $this->filterModule($_module, $filters);

    }

    public function filterModule($_module = [], $filters = []) {

        if( empty($filters) || is_string($filters) )
            return $_module;

        $module = [];

        foreach ($_module as $mod) {

            foreach ($filters as $key => $val) {

                if ( isset($mod[$key]) && ((is_array($mod[$key]) && in_array($val, $mod[$key])) || (is_string($mod[$key]) && $mod[$key] == $val)) ) {

                    $_filter[$key] = true;

                } else { $_filter[$key] = false; }

            }

            if (!in_array(false, $_filter))
                $module[$mod['name']] = $mod;
        }

        return $module;

    }
/*
    public function listModules() {

        $modules = [];

        $moduledirs = [
            'core'   => COCKPIT_DIR.'/modules',
            'addons' => COCKPIT_DIR.'/addons'
        ];
        foreach ($this->app['loadmodules'] ?? [] as $dir)
            $moduledirs['other'][] = $dir;

        foreach ($moduledirs as $type => $dir) {

            foreach ($this->app->helper('fs')->ls('*', $dir) as $module) {

                if ($module->isFile() || $module->isDot()) continue;

                $name = $module->getBasename();

                $modules[$type][strtolower($name)]['name'] = $name;

            }

        }

        return $modules;

    }
*/
}