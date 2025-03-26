<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @var CMain $APPLICATION
 */

$APPLICATION->SetTitle("Компонент списка таблицы базы данных");

use Bitrix\Main\Type;
use Models\ClientsTable as Clients;


use \Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Main\Grid\Options as GridOptions;
use Bitrix\Main\UI\PageNavigation;

$list_id = 'example_list';
$num_page = 2;

$nav = new PageNavigation($list_id);
$nav->setRecordCount(Clients::getCount());
$nav->allowAllRecords(true)->setPageSize($num_page)->initFromUri();

$filterOption = new Bitrix\Main\UI\Filter\Options($list_id);
$filterData = $filterOption->getFilter([]);

$filter = [];
if (!empty($filterData['UF_NAME'])) {
    $filter['%UF_NAME'] = $filterData['UF_NAME'];
}
if (!empty($filterData['UF_LASTNAME'])) {
    $filter['%UF_LASTNAME'] = $filterData['UF_LASTNAME'];
}
if (!empty($filterData['UF_PHONE'])) {
    $filter['%UF_PHONE'] = $filterData['UF_PHONE'];
}

$res = Clients::getList([
    'filter' => $filter,
    'select' => [
        "*",
    ],
    'offset' => $nav->getOffset(),
    'limit' => $nav->getLimit(),
]);

$ui_filter = [
    ['id' => 'UF_NAME', 'name' => 'Имя', 'type' => 'text', 'default' => true],
    ['id' => 'UF_LASTNAME', 'name' => 'Фамилия', 'type' => 'text', 'default' => true],
    ['id' => 'UF_PHONE', 'name' => 'Телефон', 'type' => 'text', 'default' => true],
];

$columns = [];
$columns[] = ['id' => 'ID', 'name' => 'ID', 'sort' => 'ID', 'default' => true];
$columns[] = ['id' => 'UF_NAME', 'name' => 'Имя', 'sort' => 'UF_NAME', 'default' => true, 'editable' => true];
$columns[] = ['id' => 'UF_LASTNAME', 'name' => 'Фамилия', 'sort' => 'UF_LASTNAME', 'default' => true, 'editable' => true];
$columns[] = ['id' => 'UF_PHONE', 'name' => 'Телефон', 'sort' => 'UF_PHONE', 'default' => true, 'editable' => true];
$columns[] = ['id' => 'UF_JOBPOSITION', 'name' => 'Должность', 'sort' => 'UF_JOBPOSITION', 'default' => true, 'editable' => true];
$columns[] = ['id' => 'UF_SCORE', 'name' => 'Лояльность клиента', 'sort' => 'UF_SCORE', 'default' => true, 'editable' => true];

// pr($columns);


?>

<?$APPLICATION->IncludeComponent('bitrix:main.ui.filter', '', [
    'FILTER_ID' => $list_id,
    'GRID_ID' => $list_id,
    'FILTER' => $ui_filter,
    'ENABLE_LIVE_SEARCH' => true,
    'ENABLE_LABEL' => true
]);?>

<?

use Bitrix\Main\Grid\Panel\Snippet\Onchange;
use Bitrix\Main\Grid\Panel\Snippet;
use Bitrix\Main\Grid\Panel\Actions;
// Кнопка удалить
$onchange = new Onchange();
$onchange->addAction(
    [
        'ACTION' => Actions::CALLBACK,
        'CONFIRM' => true,
        'CONFIRM_APPLY_BUTTON'  => 'Подтвердить',
        'DATA' => [
            ['JS' => 'Grid.removeSelected()']
        ]
    ]
);

// Кнопка редактировать
$onedit = new Onchange();
$onedit->addAction(
    [
        'ACTION' => Actions::CALLBACK,
        'DATA' => [
            ['JS' => 'Grid.editSelectedSave()']
        ]
    ]
);

$list = [];
foreach ($res->fetchAll() as $row) {
    $list[] = [
        'data' => [
            "ID" => $row['ID'],
            "UF_NAME" => $row['UF_NAME'],
            "UF_LASTNAME" => $row['UF_LASTNAME'],
            "UF_PHONE" => $row['UF_PHONE'],
            "UF_JOBPOSITION" => $row['UF_JOBPOSITION'],
            "UF_SCORE" => $row['UF_SCORE'],
        ],
        'actions' => [
            [
                'text'    => 'Просмотр',
                'default' => true,
                'onclick' => 'document.location.href="?op=view&id='.$row['ID'].'"'
            ],
            [
                'text'    => 'Редактировать',
                'default' => true,
                'onclick' => 'window.editSelectedRows()'
            ],
            [
                'text'    => 'Удалить',
                'default' => true,
                'onclick' => 'if(confirm("Точно?")){document.location.href="?op=delete&id='.$row['ID'].'"}'
            ]
        ]
    ];
}

use Bitrix\Main\Grid\Panel;

$snippet = new Snippet();
$actionPanel = [
    "GROUPS" => [
        [
            "ITEMS" => [
                [
                    "TYPE" => "BUTTON",
                    "ID" => "edit_button",
                    "TEXT" => "Редактировать",
                    "CLASS" => "edit-button",
                    "ONCHANGE" => [
                        [
                            "ACTION" => Bitrix\Main\Grid\Panel\Actions::CALLBACK,
                            "DATA" => [
                                ["JS" => "editSelectedRows()"]
                            ]
                        ]
                    ]
                ],
                [
                    "TYPE" => "BUTTON",
                    "ID" => "save_button",
                    "TEXT" => "Сохранить",
                    "CLASS" => "save-button",
                    "ONCHANGE" => [
                        [
                            "ACTION" => Bitrix\Main\Grid\Panel\Actions::CALLBACK,
                            "DATA" => [
                                ["JS" => "saveSelectedRows()"]
                            ]
                        ]
                    ]
                ],
            ],
        ],
    ],
];
?>

<?$APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', [
    'GRID_ID' => $list_id,
    'COLUMNS' => $columns,
    'ROWS' => $list,
    'SHOW_ROW_CHECKBOXES' => true,
    'NAV_OBJECT' => $nav,
    'AJAX_MODE' => 'Y',
    'AJAX_ID' => \CAjax::getComponentID('bitrix:main.ui.grid', '.default', ''),
    'PAGE_SIZES' =>  [
        ['NAME' => '20', 'VALUE' => '20'],
        ['NAME' => '50', 'VALUE' => '50'],
        ['NAME' => '100', 'VALUE' => '100']
    ],
    'AJAX_OPTION_JUMP'          => 'N',
    'SHOW_CHECK_ALL_CHECKBOXES' => true,
    'SHOW_ROW_ACTIONS_MENU'     => true,
    'SHOW_GRID_SETTINGS_MENU'   => true,
    'SHOW_NAVIGATION_PANEL'     => true,
    'SHOW_PAGINATION'           => true,
    'SHOW_SELECTED_COUNTER'     => true,
    'SHOW_TOTAL_COUNTER'        => true,
    'SHOW_PAGESIZE'             => true,
    'SHOW_ACTION_PANEL'         => true,
    'SHOW_GROUP_EDIT_BUTTON'    => true,
    'ALLOW_COLUMNS_SORT'        => true,
    'ALLOW_COLUMNS_RESIZE'      => true,
    'ALLOW_HORIZONTAL_SCROLL'   => true,
    'ALLOW_SORT'                => true,
    'ALLOW_PIN_HEADER'          => true,
    'ALLOW_INLINE_EDIT'         => true,
    'ALLOW_ROWS_SORT_IN_EDIT_MODE' => true,
    'ALLOW_EDIT_SELECTION'      => true,
    'AJAX_OPTION_HISTORY'       => 'N',
    'EDITABLE'                  => true,
    'ACTION_PANEL'              => $actionPanel,
]);?>
<script>
    BX.ready(function() {
              
        BX.bindDelegate(document.body, 'click', {className: 'grid-delete-button'}, function() {
            
            var grid = BX.Main.gridManager.getById('example_list');
            var selectedIds = grid.instance.getRows().getSelectedIds();

            if (selectedIds.length > 0) {
                if (confirm('Вы уверены, что хотите удалить выбранные записи?')) {
                    
                    BX.ajax.runComponentAction('otus:gridcontroller', 'deleteRecords', {
                        data: { ids: selectedIds }
                    }).then(function(response) {
                        if (response.status === 'success') {
                            grid.reload();
                        } else {
                            console.log('Ошибка при удалении записей');
                        }
                    });
                }
            } else {
                console.log('Выберите хотя бы одну запись для удаления');
            }
        });
        
    });

    BX.ready(function() {
        window.editSelectedRows = function() {
            var grid = BX.Main.gridManager.getById('example_list');
            if (grid) {
                var selectedRows = grid.instance.getRows().getSelected();
                if (selectedRows.length === 0) {
                    BX.UI.Notification.Center.notify({
                        content: 'Пожалуйста, выберите строки для редактирования.'
                    });
                    return;
                }
                selectedRows.forEach(function(row) {
                    row.edit();
                });
            }
        };

        window.saveSelectedRows = function() {
            var grid = BX.Main.gridManager.getById('example_list');
            if (grid) {
                var selectedRows = grid.instance.getRows().getSelected();
                if (selectedRows.length === 0) {
                    BX.UI.Notification.Center.notify({
                        content: 'Пожалуйста, выберите строки для сохранения.'
                    });
                    return;
                }
                selectedRows.forEach(function(row) {
                    var data = row.getEditData();
                    BX.ajax.runComponentAction('bitrix:main.ui.grid', 'updateRow', {
                        mode: 'class',
                        data: data
                    }).then(function(response) {
                        if (response.status === 'success') {
                            BX.UI.Notification.Center.notify({
                                content: 'Изменения успешно сохранены!'
                            });
                            row.unedit();
                        } else {
                            BX.UI.Notification.Center.notify({
                                content: 'Ошибка при сохранении изменений.'
                            });
                        }
                    });
                });
            }
        };
    });



</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>