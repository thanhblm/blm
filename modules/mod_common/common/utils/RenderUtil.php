<?php

namespace common\utils;

use core\config\ModuleConfig;
use core\utils\RouteUtil;

class RenderUtil {
    public static function getViewPath() {
        return ModuleConfig::getModuleConfig ( 'mod_common_lib' ) ['VIEW_PATH'];
    }
    public static function recursive($data, $parentId, $level, $levelMax, $haveChild, $template, $params) {
        if ($levelMax != 0 && $level > $levelMax) {
            return;
        }
        $class = (isset ( $params ['class'] [$level] )) ? "class='{$params['class'][$level]} ul_$level'" : "class='ul_$level'";
        $id = (isset ( $params ['id'] [$level] )) ? "id='{$params['id'][$level]}'" : "";
        $attributes = (isset ( $params ['attributes'] [$level] )) ? $params ['attributes'] [$level] : "";
        $container = (isset ( $params ['container'] )) ? $params ['container'] : 'ul';

        if ($haveChild) {
            echo ($container == 'ul') ? "<ul $class $id $attributes>\n" : "<div $class $id $attributes>\n";
        }
        foreach ( $data as $v ) {
            if ($v ['parentId'] == $parentId) {
                $level ++;
                include $template;
                self::recursive ( $data, $v ['id'], $level, $levelMax, $v ['haveChild'], $template, $params );
                $level --;
                echo ($container == 'ul') ? "</li>\n" : "</div>\n";
            }
        }
        if ($haveChild) {
            echo ($container == 'ul') ? "</ul> <!-- end .ul_$level -->\n" : "</div> <!-- end .ul_$level -->\n";
        }
    }

    public static function renderLayout($data, $parentId, $level, $levelMax, $haveChild, $template, $params){
        if($levelMax != 0 && $level > $levelMax) return;

        $class = (isset($params['class'][$level])) ? "class='{$params['class'][$level]} ul_$level'" : "class='ul_$level'";
        $id = (isset($params['id'][$level])) ? "id='{$params['id'][$level]}'" : "";
        $attributes = (isset($params['attributes'][$level])) ? $params['attributes'][$level] : "";
        $container = (isset($params['container'])) ? $params['container'] : 'ul';

        if($haveChild){
            echo ($container == 'ul') ? "<ul $class $id $attributes>\n" : "<div $class $id $attributes>\n";
        }
        foreach($data as $v){
            if($v['status'] == 'deactive' || $v['statusParent'] == 'deactive') continue;
            if($v['parentId'] == $parentId){
                if(!$v['fluidContainer']) echo "<div class='container'>";
                $level++;
                include $template;
                self::renderLayout($data, $v['id'], $level, $levelMax, $v['haveChild'], $template, $params);
                $level--;
                if(!$v['fluidContainer']) echo "</div> <!-- end .container-->";
                echo ($container == 'ul') ? "</li>\n" : "</div>\n";
            }
        }
        if($haveChild){
            echo ($container == 'ul') ? "</ul> <!-- end .ul_$level -->\n" : "</div> <!-- end .ul_$level -->\n";
        }
    }
}