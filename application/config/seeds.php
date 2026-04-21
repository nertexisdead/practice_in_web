<?php

return [

    'roles' => [
        ['id' => 1, 'name' => 'Супер Администратор', 'slug' => 'superadmin'],
        ['id' => 2, 'name' => 'Администратор', 'slug' => 'admin'],
        ['id' => 4, 'name' => 'Пользователь', 'slug' => 'user']
    ],

    'categories' => [
        ['id' => 1, 'parent_id' => null, 'alias' => 'auto-parts', 'name' => 'Автозапчасти'],
        ['id' => 2, 'parent_id' => null, 'alias' => 'engine-parts', 'name' => 'Детали двигателя'],
        ['id' => 3, 'parent_id' => null, 'alias' => 'transmission-parts', 'name' => 'Трансмиссия'],
        ['id' => 4, 'parent_id' => null, 'alias' => 'suspension-steering', 'name' => 'Подвеска и рулевое'],
        ['id' => 5, 'parent_id' => null, 'alias' => 'brake-system', 'name' => 'Тормозная система'],
        ['id' => 6, 'parent_id' => null, 'alias' => 'electrics-lighting', 'name' => 'Электрика и свет'],
        ['id' => 7, 'parent_id' => null, 'alias' => 'body-interior', 'name' => 'Кузов и салон'],
        ['id' => 8, 'parent_id' => null, 'alias' => 'fluids-chemistry', 'name' => 'Жидкости и автохимия'],
        ['id' => 9, 'parent_id' => null, 'alias' => 'tools-equipment', 'name' => 'Инструменты и оборудование'],
        ['id' => 10, 'parent_id' => null, 'alias' => 'accessories', 'name' => 'Аксессуары'],

        ['id' => 11, 'parent_id' => 2, 'alias' => 'filters', 'name' => 'Фильтры'],
        ['id' => 12, 'parent_id' => 2, 'alias' => 'timing-system', 'name' => 'Система ГРМ'],
        ['id' => 13, 'parent_id' => 2, 'alias' => 'fuel-system', 'name' => 'Топливная система'],
        ['id' => 14, 'parent_id' => 2, 'alias' => 'cooling-system', 'name' => 'Система охлаждения'],
        ['id' => 15, 'parent_id' => 2, 'alias' => 'ignition-system', 'name' => 'Система зажигания'],

        ['id' => 16, 'parent_id' => 3, 'alias' => 'clutch-parts', 'name' => 'Сцепление'],
        ['id' => 17, 'parent_id' => 3, 'alias' => 'gearbox-parts', 'name' => 'Коробка передач'],
        ['id' => 18, 'parent_id' => 3, 'alias' => 'driveshaft-cv-joints', 'name' => 'Приводы и ШРУС'],
        ['id' => 19, 'parent_id' => 3, 'alias' => 'differential-parts', 'name' => 'Дифференциал'],
        ['id' => 20, 'parent_id' => 3, 'alias' => 'transmission-mounts', 'name' => 'Опоры трансмиссии'],

        ['id' => 21, 'parent_id' => 4, 'alias' => 'shock-absorbers', 'name' => 'Амортизаторы'],
        ['id' => 22, 'parent_id' => 4, 'alias' => 'springs', 'name' => 'Пружины'],
        ['id' => 23, 'parent_id' => 4, 'alias' => 'control-arms', 'name' => 'Рычаги подвески'],
        ['id' => 24, 'parent_id' => 4, 'alias' => 'wheel-bearings', 'name' => 'Ступицы и подшипники'],
        ['id' => 25, 'parent_id' => 4, 'alias' => 'steering-rack-tie-rods', 'name' => 'Рулевая рейка и тяги'],

        ['id' => 26, 'parent_id' => 5, 'alias' => 'brake-pads', 'name' => 'Тормозные колодки'],
        ['id' => 27, 'parent_id' => 5, 'alias' => 'brake-discs-drums', 'name' => 'Диски и барабаны'],
        ['id' => 28, 'parent_id' => 5, 'alias' => 'brake-calipers', 'name' => 'Суппорты'],
        ['id' => 29, 'parent_id' => 5, 'alias' => 'brake-hoses-lines', 'name' => 'Тормозные шланги и трубки'],
        ['id' => 30, 'parent_id' => 5, 'alias' => 'abs-sensors', 'name' => 'Датчики ABS'],

        ['id' => 31, 'parent_id' => 6, 'alias' => 'batteries', 'name' => 'Аккумуляторы'],
        ['id' => 32, 'parent_id' => 6, 'alias' => 'starters-alternators', 'name' => 'Стартеры и генераторы'],
        ['id' => 33, 'parent_id' => 6, 'alias' => 'headlights-lamps', 'name' => 'Фары и лампы'],
        ['id' => 34, 'parent_id' => 6, 'alias' => 'sensors-relays', 'name' => 'Датчики и реле'],
        ['id' => 35, 'parent_id' => 6, 'alias' => 'wiring-fuses', 'name' => 'Проводка и предохранители'],

        ['id' => 36, 'parent_id' => 7, 'alias' => 'mirrors-glass', 'name' => 'Зеркала и стекла'],
        ['id' => 37, 'parent_id' => 7, 'alias' => 'bumpers-grilles', 'name' => 'Бамперы и решетки'],
        ['id' => 38, 'parent_id' => 7, 'alias' => 'door-locks-handles', 'name' => 'Замки и ручки дверей'],
        ['id' => 39, 'parent_id' => 7, 'alias' => 'interior-trim', 'name' => 'Элементы салона'],
        ['id' => 40, 'parent_id' => 7, 'alias' => 'wipers-washers', 'name' => 'Дворники и омыватели'],

        ['id' => 41, 'parent_id' => 8, 'alias' => 'engine-oils', 'name' => 'Моторные масла'],
        ['id' => 42, 'parent_id' => 8, 'alias' => 'transmission-oils', 'name' => 'Трансмиссионные масла'],
        ['id' => 43, 'parent_id' => 8, 'alias' => 'coolants', 'name' => 'Антифризы'],
        ['id' => 44, 'parent_id' => 8, 'alias' => 'brake-fluids', 'name' => 'Тормозные жидкости'],
        ['id' => 45, 'parent_id' => 8, 'alias' => 'car-care-chemicals', 'name' => 'Автохимия и уход'],

        ['id' => 46, 'parent_id' => 9, 'alias' => 'hand-tools', 'name' => 'Ручной инструмент'],
        ['id' => 47, 'parent_id' => 9, 'alias' => 'diagnostic-tools', 'name' => 'Диагностическое оборудование'],
        ['id' => 48, 'parent_id' => 9, 'alias' => 'garage-equipment', 'name' => 'Гаражное оборудование'],
        ['id' => 49, 'parent_id' => 10, 'alias' => 'car-electronics', 'name' => 'Автоэлектроника'],
        ['id' => 50, 'parent_id' => 10, 'alias' => 'seasonal-accessories', 'name' => 'Сезонные аксессуары'],
    ],
];
