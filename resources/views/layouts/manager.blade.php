<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('images/favicon.ico')}}"/>

    <link rel="stylesheet" href="{{ URL::asset('css/styles.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/jquery.arcticmodal.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/tooltipster.bundle.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/tooltipster-sideTip-light.min.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/simple.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/admin.css')}}" />
    <link rel="stylesheet" href="{{ URL::asset('css/jquery-ui.css')}}" />

    <script src="{{ URL::asset('js/min/manager-common.js')}}"></script>
    @yield('javascript')
</head>
<body>
<div class="page-wrap">
    <div class="loading">
        <img src="{{ URL::asset('images/loading.gif')}}" />
    </div>
    <div class="menu">
        <a href="/admin/main" data-bind="css: {'current': $root.page() === menu.admin.main}">Главная</a>
        <a href="/admin/lecturers" data-bind="css: {'current': $root.page() === menu.admin.lecturers}">Преподаватели</a>
        <a href="/admin/groups" data-bind="css: {'current': $root.page() === menu.admin.groups}">Группы</a>
        <a href="/admin/students" data-bind="css: {'current': $root.page() === menu.admin.students}">Студенты</a>
        <a href="/admin/disciplines" data-bind="css: {'current': $root.page() === menu.admin.disciplines}">Дисциплины</a>
        <a href="/admin/tests" data-bind="css: {'current': $root.page() === menu.admin.tests}">Тесты</a>
        <a href="/admin/results" data-bind="css: {'current': $root.page() === menu.admin.results}">Результаты</a>
        <a href="/admin/performance" data-bind="css: {'current': $root.page() === menu.admin.performance}">Успеваемость</a>
        <a href="/admin/materials" data-bind="css: {'current': $root.page() === menu.admin.materials}">Материалы</a>
        <a href="https://localhost:5001/learning">Обучение</a>
        <a  class="user" data-bind="text: $root.user.name()"></a>
        <div class="menu-dd">
            <!-- ko if: $root.user.role() === role.admin.name -->
            <a href="/admin/setting">Администрирование</a>
            <!-- /ko -->
            <!-- ko if: $root.user.role() === role.lecturer.name -->
            <a href="/admin/help/navigation">Помощь</a>
            <!-- /ko -->
            <a data-bind="click: $root.user.password.change.bind($root)">Сменить пароль</a>
            <a href="/logout">Выход</a>
        </div>
    </div>
    @yield('content')
    @include('shared.common-modals')
</div>
@include('shared.footer')
</body>
</html>