<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
/**
 * @var CMain $APPLICATION
 */
$APPLICATION->SetTitle("PopUp");
CJSCore::Init(array("popup"));

?>
    <script>
        // BX.element - элемент, к которому будет привязано окно, если null – окно появится по центру экрана
        let int_puts = "<input id='fio' type='text' name='fio' size='35' placeholder='ФИО клиента'>" +
            "<br><input type='text' name='time_rec' size='35' placeholder='Время записи' onclick='BX.calendar({node: this, field: this, bTime: true});'>";

        //var fio = document.getElementsByName("fio");

        // функция которую инициализируем, например по клику на кнопку
        function LazyBanner(fio, time, procedure) {
            BX.ajax({
                url: '/ajax.php', // файл на который идет запрос
                method: 'POST', // метод запроса GET/POST
                // параметры передаваемый запросом
                data: {
                    FIO: fio,
                    TIME_REC: time,
                    PROCEDURE: procedure
                },
                // ответ сервера лежит в data
                onsuccess: function(data) {
                    console.log(data);
                }
            })
        }

        BX.ready(function () {
            var popup = BX.PopupWindowManager.create("popup-message", BX('element'), {
                content: int_puts,
                width: 400, // ширина окна
                height: 300, // высота окна
                zIndex: 100, // z-index
                closeIcon: {
                    // объект со стилями для иконки закрытия, при null - иконки не будет
                    opacity: 1
                },
                titleBar: 'Записать клиента',
                closeByEsc: true, // закрытие окна по esc
                darkMode: false, // окно будет светлым или темным
                autoHide: false, // закрытие при клике вне окна
                draggable: true, // можно двигать или нет
                resizable: true, // можно ресайзить
                min_height: 100, // минимальная высота окна
                min_width: 100, // минимальная ширина окна
                lightShadow: true, // использовать светлую тень у окна
                angle: false, // появится уголок
                overlay: {
                    // объект со стилями фона
                    backgroundColor: 'black',
                    opacity: 500
                },
                buttons: [
                    new BX.PopupWindowButton({
                        text: 'Записать', // текст кнопки
                        id: 'save-btn', // идентификатор
                        className: 'ui-btn ui-btn-success', // доп. классы
                        events: {
                            click: function() {
                                // Событие при клике на кнопку
                                let Fio = document.getElementsByName("fio")[0].value;
                                let Time = document.getElementsByName("time_rec")[0].value;
                                let Procedure = 43;
                                LazyBanner(Fio, Time, Procedure);
                                window.location.href = 'https://ce76367.tw1.ru/services/lists/41/view/0/?list_section_id=';
                            }
                        }
                    }),
                    new BX.PopupWindowButton({
                        text: 'Закрыть',
                        id: 'close-btn',
                        className: 'ui-btn ui-btn-primary',
                        events: {
                            click: function() {
                                popup.close();
                            }
                        }
                    })
                ],
                events: {
                    onPopupShow: function() {
                        // Событие при показе окна
                    },
                    onPopupClose: function() {
                        // Событие при закрытии окна
                    }
                }
            });

            BX.bindDelegate(
                document.body, 'click', {className: 'css_popup' },
                BX.proxy(function(e){
                    if(!e)
                        e = window.event;
                    popup.show();
                    return BX.PreventDefault(e);
                }, popup)
            );

        });
    </script>
    <div class="css_popup">Нажми меня</div>
<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>