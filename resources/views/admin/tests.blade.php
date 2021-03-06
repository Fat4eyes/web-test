@extends('layouts.manager')
@section('title', 'Тесты')
@section('javascript')
    <link rel="stylesheet" href="{{ URL::asset('css/tooltipster.bundle.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/tooltipster-sideTip-light.min.css')}}"/>
    <script src="{{ URL::asset('js/min/manager-tests.js')}}"></script>
@endsection

@section('content')
<div class="content">
    <div class="items">
        <div class="items-head">
            <h1>Администрирование тестов</h1>
            <!-- ko if: $root.filter.discipline() -->
            <label class="adder" data-bind="click: $root.actions.start.add">Добавить</label>
            <!-- /ko -->
        </div>
        <!-- ko if: !$root.filter.discipline() && !$root.current.tests.length -->
        <h3 class="text-center">Пожалуйста, выберите дисциплину</h3>
        <!-- /ko -->
        <!-- ko if: $root.mode() === state.create-->
        <div data-bind="template: {name: 'show-details', data: $root.current.test}"></div>
        <!-- /ko -->
        <div class="items-body">
            <!-- ko foreach: $root.current.tests -->
            <div class="item" data-bind="text: subject, click: $root.actions.show, css: {'current': $root.current.test().id() === id()}"></div>
            <!-- ko if: $root.mode() !== state.none && $root.current.test().id() === id() -->
            <div data-bind="template: {name: 'show-details', data: $root.current.test}"></div>
            <!-- /ko -->
            <!-- /ko -->
        </div>

        @include('shared.pagination')
    </div>
    <div class="filter">
        <div class="filter-block">
            <label class="title">Дисциплина</label>
            <select data-bind="options: $root.current.disciplines,
                       optionsText: 'name',
                       value: $root.filter.discipline,
                       optionsCaption: 'Выберите дисциплину'"></select>
        </div>
        <div class="filter-block">
            <label class="title">Тест</label>
            <input type="text" data-bind="value: $root.filter.name, valueUpdate: 'keyup'" placeholder="Название теста">
        </div>
        <div class="filter-block">
            <span class="radio">Только активные: </span>
            <span class="radio form-heights" data-bind="css: {'radio-important': $root.filter.isActive()}, click: () => $root.filter.isActive(true)">Да</span>
            <span>|</span>
            <span class="radio form-heights" data-bind="css: {'radio-important': !$root.filter.isActive()}, click: () => $root.filter.isActive(false)">Нет</span>
        </div>
        <div class="filter-block">
            <span class="clear" data-bind="click: $root.filter.clear">Очистить</span>
        </div>
    </div>
</div>

<script type="text/html" id="show-details">
    <div>
        <!-- ko if: $root.mode() === state.info || $root.mode() === state.remove -->
        <div class="width100" data-bind="template: {name: 'info-mode', data: $data}"></div>
        <!-- /ko -->
        <!-- ko if: $root.mode() === state.update || $root.mode() === state.create-->
        <div class="width100" data-bind="template: {name: 'edit-mode', data: $data}"></div>
        <!-- /ko -->
    </div>
</script>
<script type="text/html" id="info-mode">
    <div class="details test">
        <div class="details-row">
            <div class="details-column">
                <label class="title">Название</label>
                <span class="info" data-bind="text: subject"></span>
            </div>
            <div class="details-column">
                <label class="title">Тип</label>
                <span class="info" data-bind="text: type() ? 'Контроль знаний' : 'Обучающий'"></span>
            </div>
            <div class="details-column">
                <label class="title">Время</label>
                <span class="info" data-bind="text: minutes() + ':' + seconds()"></span>
            </div>
            <div class="details-column">
                <label class="title">Общее время</label>
                <span class="info" data-bind="text: totalTimeInSeconds"></span>
            </div>
            <div class="details-column">
                <label class="title">Общее количество вопросов</label>
                <span class="info" data-bind="text: questionsCount"></span>
            </div>
        </div>
        <div class="details-row float-buttons">
            <div class="details-column width-100p">
                <button class="remove" data-bind="click: $root.actions.start.remove"><span class="fa">&#xf014;</span>&nbsp;Удалить</button>
                <button class="approve" data-bind="click: $root.actions.start.update"><span class="fa">&#xf040;</span>&nbsp;Редактировать</button>
            </div>
        </div>
    </div>
</script>
<script type="text/html" id="edit-mode">
    <div class="details">
        <div class="details-row">
            <div class="details-column width-98p">
                <label class="title">Название&nbsp;<span class="required">*</span></label>
                <input type="text" id="iTestSubject" validate
                       data-bind="value: subject,
                       valueUpdate: 'keyup',
                       validationElement: subject,
                       event: {focusout: $root.events.focusout, focusin: $root.events.focusin}">
            </div>
        </div>
        <div class="details-row">
            <div class="details-column minw-130">
                <label class="title">Дительность&nbsp;теста&nbsp;<span class="required">*</span></label>
                <input class="time" type="text" id="iTestMinutes"
                       data-bind="value: minutes, valueUpdate: 'keyup',
                       validationElement: minutes,
                       event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"
                       placeholder="мин." validate>
                <span>:</span>
                <input class="time" type="text" id="iTestSeconds"
                       data-bind="value: seconds,
                       valueUpdate: 'keyup',
                       validationElement: seconds,
                       event: {focusout: $root.events.focusout, focusin: $root.events.focusin}"
                       placeholder="сек." validate>
            </div>
            <div class="details-column attempts minw-130 width-20p">
                <label class="title">Количество&nbsp;попыток&nbsp;<span class="required">*</span></label>
                <input class="attempts" type="text" id="iTestAttempts" validate
                       data-bind="value: attempts,
                       valueUpdate: 'keyup',
                       validationElement: attempts,
                       event: {focusout: $root.events.focusout, focusin: $root.events.focusin}">
            </div>
            <div class="details-column minw-220">
                <label class="title">Тип&nbsp;теста</label>
                <span class="radio form-heights" data-bind="css: {'radio-important': type()}, click: $root.alter.set.type.asTrue">Контроль знаний</span>
                <span>|</span>
                <span class="radio form-heights" data-bind="css: {'radio-important': !type()}, click: $root.alter.set.type.asFalse">Обучающий</span>
            </div>
        </div>
        <div class="details-row">
            <div id="dTestThemesMulti" class="details-column width-98p"
                 title="Пожалуйста, укажите хотя бы одну тему" validate special
                 data-bind="with: $root.multiselect">
                <label class="title">Темы&nbsp;<span class="required">*</span></label>
                <multiselect params="{source: $root.multiselect.data, tags: $root.multiselect.tags}"></multiselect>
            </div>
        </div>
        <div class="details-row float-buttons">
            <div class="details-column width-99p">
                <span class="float-left">
                    <input class="custom-checkbox" id="test-is-active" type="checkbox" data-bind="checked: isActive">
                    <label for="test-is-active">Активный</label>
                </span>

                <button data-bind="click: $root.actions.cancel" class="cancel">Отмена</button>
                <button id="bUpdateLecturer" accept-validation class="approve"
                        title="Проверьте правильность заполнения полей"
                        data-bind="click: $root.actions.end.update">Сохранить</button>
            </div>
        </div>

    </div>
</script>
@endsection

<div class="g-hidden">
    <div class="box-modal removal-modal" id="remove-test-modal">
        <div class="layer zero-margin width-auto">
            <div class="layer-head">
                <h3>Удалить выбранный тест?</h3>
            </div>
            <div class="layer-body">
                <div class="details-row float-buttons">
                    <button class="cancel arcticmodal-close">Отмена</button>
                    <button class="remove arcticmodal-close" data-bind="click: $root.actions.end.remove">Удалить</button>
                </div>
            </div>
        </div>
    </div>
</div>