<?
/**
 * 重新定义url规则
 */
//定义专利详情规则
$rules[] = array(
    '#/pt-#',
    array('mod' => 'patent', 'action' => 'view'),
    array(
        'short' => '#(-\w+(\.[\dxX])?)#',
    ),
);
?>