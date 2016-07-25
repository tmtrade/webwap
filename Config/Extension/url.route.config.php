<?
/**
 * 重新定义url规则
 */
//定义专利详情规则
$rules[] = array(
    '#/pt-#',
    array('mod' => 'ptdetail', 'action' => 'index'),
    array(
        'short' => '#(-\w+(\.[\dxX])?)#',
    ),
);
$rules[] = array(
    '#/d-#',
    array('mod' => 'trademark', 'action' => 'detail'),
    array(
        'short' => '#((\d+-)([\w-])*)#',
        ),
);
?>