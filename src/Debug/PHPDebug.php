<?php

namespace Debug;

class PHPDebug
{
    static protected function init()
    {
        $css = "<style>
            .flex-container {
                display: flex;
                background-color: DodgerBlue;
            }
    
            .flex-container > div {
                background-color: #f1f1f1;
                margin: 2px;
                padding: 5px;
                font-size: 19px;
            }
        </style>";

        $js = "function toggle(tag, display) {
          if (display == 'none') {
                  tag.style.display = 'block';
              }
        
              if (display == 'block') {
                  tag.style.display = 'none';
              }
          }
    
    function dump(el) {
          const tag = el.parentElement.nextSibling;
          const display = tag.style.display;
          toggle(tag, display);
    }";

        echo "<style>$css</style>";
        echo "<script>$js</script>";
    }

    static function console( ...$messages ) {
        foreach ($messages as $msg) {
            echo '<script>';
            echo 'console.log('.json_encode($msg).'); console.log('.''.');';
            echo '</script>';
        }
    }

    static function dump($data, array $dump_param = ['name' => '', 'position' => 'initial'])
    {
        self::init();

        echo '<div class__="flex-container" style="display__: flex; position__: absolute; width__: auto; z-index__: 100;">';

        if (array_key_exists('position', $dump_param)) {
            echo '<div style="position: '.$dump_param['position'].'; width: auto; z-index: 100;">';
        } else {
            echo '<div style="position: initial; width: auto; z-index: 100;">';
        }

        $class = self::randomString(10);

        if (array_key_exists('name', $dump_param)) {
            if ($dump_param['name']) {
                $varName = $dump_param['name'];
            } else {
                $varName = '';
            }
        } else {
            $varName = '';
        }

        echo '<div><button class="'.$class.'" onclick="dump(this)" style="background-color: #454545; color: #cccccc;">dump <span style="color: orange">'.$varName.'</span></button></div>';
        echo '<div id="dump" class="'.$class.'" style="background-color: #454545; padding: 7px; border: #cccccc solid 3px; color: #cccccc; display: none;">';

        if (array_key_exists('name', $dump_param)) {
            if ($dump_param['name']) {
                echo '<span style="color: orange"><b>'.$dump_param['name'].'</b></span>';
                echo '<br><br>';
            }
        }

        if (is_object($data) || is_array($data)) {
            foreach ($data as $k => $v) {
                echo $k.'=';

                if (is_object($v) || is_array($v)) {
                    echo '<span style="color: navajowhite">';
                    print_r($v);
                    echo '</span>';
                } else {
                    echo $v;
                }

                echo '<br/>';
            }
        } else {
            print_r($data);
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
