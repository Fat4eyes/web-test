@extends('shared.layout')
@section('title', 'Тесты')
@section('javascript')
    <link rel="stylesheet" href="{{ URL::asset('css/tooltipster.bundle.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/tooltipster-sideTip-light.min.css')}}"/>
    {{--<link rel="stylesheet" href="{{ URL::asset('css/knockout.autocomplete.css')}}"/>--}}
    <script src="{{ URL::asset('js/knockout.validation.js')}}"></script>
    <script src="{{ URL::asset('js/tooltipster.bundle.js')}}"></script>
    <script src="{{ URL::asset('js/knockout.autocomplete.js')}}"></script>
    <script src="{{ URL::asset('js/admin/tests.js')}}"></script>
@endsection

@section('content')
<div class="content">
    <div class="filter">
        <div>
            <label>Название теста</label></br>
            <input type="text" data-bind="value: $root.filter.name, valueUpdate: 'keyup'">
        </div>
        <div>
            <label>Дициплина</label></br>
            <select data-bind="options: $root.current.disciplines,
                       optionsText: 'name',
                       value: $root.filter.discipline,
                       optionsCaption: 'Выберете дисциплину'"></select>
        </div>
    </div>

    {{--<div class="multiselect-wrap">--}}
        {{--<div class="multiselect">--}}
            {{--<ul data-bind="foreach: $root.multiselect.tags">--}}
                {{--<li><span data-bind="click: $root.multiselect.remove" class="fa">&#xf00d;</span><span data-bind="text: name"></span></li>--}}
            {{--</ul>--}}
        {{--</div>--}}
        {{--<input data-bind="autocomplete: { data: $root.current.themes, format: $root.multiselect.show, onSelect: $root.multiselect.select}" value=""/>--}}
    {{--</div>--}}

    <div class="org-accordion">
        <div data-bind="click: $root.csed.test.toggleAdd" class="org-item">
            <span class="fa">&#xf067;</span>
        </div>
        <!-- ko if: $root.mode() === 'add'-->
            <div data-bind="template: {name: 'show-details', data: $root.current.test}"></div>
        <!-- /ko -->
        <!-- ko foreach: $root.current.tests -->
            <div class="org-item" data-bind="text: subject, click: $root.csed.test.show"></div>
            <!-- ko if: $root.mode() !== 'none' && $root.current.test().id() === $data.id() -->
                <div data-bind="template: {name: 'show-details', data: $root.current.test}"></div>
            <!-- /ko -->
        <!-- /ko -->
    </div>
    <!-- ko if: $root.pagination.itemsCount() > $root.pagination.pageSize() -->
    <div class="pager-wrap">
        <!-- ko if: ($root.pagination.totalPages()) > 0 -->
        <div class="pager">
            <!-- ko ifnot: $root.pagination.currentPage() == 1 -->
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, 1)">&lsaquo;&lsaquo;</button>
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, ($root.pagination.currentPage() - 1))">&lsaquo;</button>
            <!-- /ko -->
            <!-- ko foreach: new Array($root.pagination.totalPages()) -->
            <span data-bind="visible: $root.pagination.dotsVisible($index() + 1)">...</span>
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, ($index()+1)), text: ($index()+1), visible: $root.pagination.pageNumberVisible($index() + 1), css: {current: ($index() + 1) == $root.pagination.currentPage()}"></button>
            <!-- /ko -->
            <!-- ko ifnot: $root.pagination.currentPage() == $root.pagination.totalPages() -->
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, ($root.pagination.currentPage() + 1))">&rsaquo;</button>
            <button class="" data-bind="click: $root.pagination.selectPage.bind($data, $root.pagination.totalPages())">&rsaquo;&rsaquo;</button>
            <!-- /ko -->
        </div>
        <!-- /ko -->
    </div>
    <!-- /ko -->
</div>

<div class="g-hidden">
    <div class="box-modal" id="delete-modal">
        <div>
            <div><span>Удалить выбранный тест?</span></div>
            <div>
                <button data-bind="click: $root.csed.test.remove" class="fa">&#xf00c;</button>
                <button data-bind="click: $root.csed.test.cancel" class="fa danger arcticmodal-close">&#xf00d;</button>
            </div>
        </div>
    </div>
</div>
<div class="tooltip_templates">
    <span id="subject_tooltip">
        <span data-bind="validationMessage: $root.current.test().subject"></span>
    </span>
    <span id="minutes_tooltip">
        <span data-bind="validationMessage: $root.current.test().minutes"></span>
    </span>
    <span id="seconds_tooltip">
        <span data-bind="validationMessage: $root.current.test().seconds"></span>
    </span>
    <span id="tryouts_tooltip">
        <span data-bind="validationMessage: $root.current.test().attempts"></span>
    </span>
</div>

<script type="text/html" id="show-details">
    <div class="org-info test">
        <!-- ko if: $root.mode() === 'info' || $root.mode() === 'delete' -->
        <div class="width100" data-bind="template: {name: 'info-mode', data: $data}"></div>
        <!-- /ko -->
        <!-- ko if: $root.mode() === 'edit' || $root.mode() === 'add'-->
        <div class="width100" data-bind="template: {name: 'edit-mode', data: $data}"></div>
        <!-- /ko -->
    </div>
</script>
<script type="text/html" id="info-mode">
    <div class="org-info-details width100">
        <div class="name">
            <label>Название</label></br>
            <span data-bind="text: subject"></span>
        </div>
        <div class="type">
            <label>Тип</label></br>
            <span data-bind="text: $root.current.type().name"></span>
        </div>
        <div class="time">
            <label>Время</label></br>
            <span data-bind="text: minutes"></span>
            <span>:</span>
            <span data-bind="text: seconds"></span>
        </div>

        <div class="btn-group">
            <button data-bind="click: $root.csed.test.startEdit" class="fa">&#xf040;</button>
            <button data-bind="click: $root.csed.test.startRemove" class="fa danger">&#xf014;</button>
        </div>
    </div>
</script>
<script type="text/html" id="edit-mode">
    <div class="org-info-edit width100">
        <div class="name">
            <label>Название</label></br>
            <input tooltip-mark="subject_tooltip" type="text" data-bind="value: subject, event: {focusin: $root.events.focusin, focusout: $root.events.focusout}">
        </div>
        <div class="type">
            <label>Тип теста</label></br>
            <select data-bind="options: $root.current.types,
                       optionsText: 'name',
                       value: $root.current.type,
                       optionsCaption: 'Выберете тип'"></select>
        </div>
        <div class="time">
            <label>Дительность теста</label></br>
            <input type="text" tooltip-mark="minutes_tooltip" data-bind="value: minutes, valueUpdate: 'keyup', event: {focusin: $root.events.focusin, focusout: $root.events.focusout} " placeholder="00">
            <span>:</span>
            <input type="text" tooltip-mark="seconds_tooltip" data-bind="value: seconds, valueUpdate: 'keyup', event: {focusin: $root.events.focusin, focusout: $root.events.focusout} " placeholder="00">
        </div>
        <div class="tryouts">
            <label>Количество попыток</label></br>
            <input tooltip-mark="tryouts_tooltip" type="text" data-bind="value: attempts, event: {focusin: $root.events.focusin, focusout: $root.events.focusout}">
        </div>
        <div class="random">
            <label>Принцип подбора вопросов</label></br>
            <span class="radio" data-bind="css: { 'radio-positive': isRandom() }, click: $root.toggleCurrent.set.random.asTrue">Случайный</span>
            <span>|</span>
            <span class="radio" data-bind="css: { 'radio-positive': isRandom() === false }, click: $root.toggleCurrent.set.random.asFalse">Адаптивный</span>
        </div>
        <div class="themes">
            <label>Темы</label></br>
            <div class="multiselect-wrap">
                <!-- ko if: $root.multiselect.tags().length -->
                <div class="multiselect">
                    <ul data-bind="foreach: $root.multiselect.tags">
                        <li><span data-bind="click: $root.multiselect.remove" class="fa">&#xf00d;</span><span data-bind="text: name"></span></li>
                    </ul>
                </div>
                <!-- /ko -->
                <input data-bind="autocomplete: { data: $root.multiselect.data, format: $root.multiselect.show, onSelect: $root.multiselect.select}, css: {'full': $root.multiselect.tags().length}" value=""/>
            </div>
        </div>
        <div class="isActive">
            <input id="test-is-active" type="checkbox" data-bind="checked: isActive"> <label for="test-is-active">Активный</label>
        </div>
        <div class="btn-group">
            <button data-bind="click: $root.csed.test.update" class="fa approve-btn">&#xf00c;</button>
            <button data-bind="click: $root.csed.test.cancel" class="fa danger">&#xf00d;</button>
        </div>
    </div>
</script>
@endsection