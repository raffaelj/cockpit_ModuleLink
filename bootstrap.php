<?php

$app->module('collections')->extend([

    // overwrite original _populate function
    '_populate' => function($items, $maxlevel = -1, $level = 0, $fieldsFilter = []) {

        if (!is_array($items)) {
            return $items;
        }

        // mini hack to populate 1 when option passed via function and param is not available
        $populate_module = $this->app->param('populate_module') ?? ($maxlevel === false ? 1 : false);

        if (isset($populate_module) && is_numeric($populate_module)) {
            $items = cockpit_populate_module($items, intval($populate_module), 0, $fieldsFilter);
        }

        // added a fix to not expand collection-links with invalid "populate":"string"
        return $maxlevel === false ? $items : cockpit_populate_collection($items, $maxlevel, 0, $fieldsFilter);

    }

]);

$app->module('collections')->extend([
    'getModuleData' => function($module, $options = []) {
        return $this->find($module, $options);
    }
]);

$app->module('singletons')->extend([
    'getModuleData' => function($module, $options = []) {
        return $this->getData($module, $options);
    }
]);

$app->module('forms')->extend([
    'getModuleData' => function($module, $options = []) {
        return $this->find($module, $options);
    }
]);


function cockpit_populate_module(&$items, $maxlevel = -1, $level = 0, $fieldsFilter = []) {

    if (!is_array($items)) {
        return $items;
    }

    if (is_numeric($maxlevel) && $maxlevel > -1 && $level > ($maxlevel+1)) {
        return $items;
    }

    foreach ($items as $k => &$v) {

        if (is_array($items[$k])) {
            $items[$k] = cockpit_populate_module($items[$k], $maxlevel, ($level + 1), $fieldsFilter);
        }

        if (isset($v['_id'], $v['module'], $v['name'], $v['display'])) {
            $link = $v['name'];
            $items[$k] = cockpit($v['module'])->getModuleData($v['name']);
            $items[$k]['_modulelink'] = $link;
            $items[$k] = cockpit_populate_module($items[$k], $maxlevel, $level, $fieldsFilter);
        }
    }

    return $items;
}

// ADMIN
if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST) {
    include_once(__DIR__ . '/admin.php');
}
