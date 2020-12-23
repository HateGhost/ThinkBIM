<?php
// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------

return [
    // 定义模板替换字符串
    'tpl_replace_string' => [
        '__APP__'  => rtrim(url('@')->build(), '\\/'),
        '__ROOT__' => rtrim(dirname(request()->basefile()), '\\/'),
        '__FULL__' => rtrim(dirname(request()->basefile(true)), '\\/'),
    ],
];
