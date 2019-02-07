$(document).ready(function () {

    var performanceViewModel = function () {
        return new function () {
            var self = this;

            initializeViewModel.call(self, {
                page: menu.admin.performance,
                mode: true
            });

            self.initial = {
                groups: ko.observableArray([])
            };

            self.settings = ko.observable(null);
            self.current = {
                disciplineGroup: ko.validatedObservable(),
                tableWidthLecture: ko.observableArray([]),
                tableWidthPractical: ko.observableArray([]),
                tableWidthLaboratory: ko.observableArray([]),
                students: ko.observableArray([]),
                student: ko.validatedObservable({
                    id: ko.observable(''),
                    firstName: ko.observable('').extend({
                        required: true,
                        pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                        maxLength: 80
                    }),
                    lastName: ko.observable('').extend({
                        required: true,
                        pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                        maxLength: 80
                    }),
                    patronymic: ko.observable('').extend({
                        pattern: '^[А-ЯЁ][а-яё]+(\-{1}(?:[А-ЯЁ]{1}(?:[а-яё]+)))?$',
                        maxLength: 80
                    }),
                    studentInitials: function (data) {
                        return data.lastName + " " + data.firstName.toString().charAt(0) + "." + data.patronymic.toString().charAt(0) + ".";
                    },
                }),
                studentAttendances: ko.observableArray([]),
                studentProgresses: ko.observableArray([]),
                studentAttendance: ko.observable({
                    id: ko.observable(''),
                    occupationNumber: ko.observable('0'),
                    occupationType: ko.observable('lecture'),
                    visitStatus: ko.observable('0'),
                    student: ko.observable(''),
                    disciplinePlan: ko.observable(''),
                }),
                studentProgress: ko.observable({
                    id: ko.observable(''),
                    workNumber: ko.observable(''),
                    occupationType: ko.observable(''),
                    workMark: ko.observable(''),
                    student: ko.observable(''),
                    disciplinePlan: ko.observable(''),
                    formattedDate: function (notFormatedDate) {
                        let date = notFormatedDate.split(' ')[0].split('-');
                        return date[2] +'/'+ date[1] +'/'+ date[0].substr(2,3);
                    },
                }),
                planId: ko.observable(),
                showToggleLecture: function (index, parentIndex) {
                    let id = 'toggleLecture' + parentIndex + '_' + index;
                    let state = 'state0';
                    if (!(document.getElementById(id).className.toString().slice(-1) === '3')) {
                        state = 'state' + (Number(document.getElementById(id).className.toString().slice(-1)) + 1);
                    }
                    this.students()[parentIndex].studentAttendances[index].visitStatus = state.slice(-1);
                    document.getElementById(id).className = state;
                },
                showTogglePractical: function (index, parentIndex) {
                    let id = 'togglePractical' + parentIndex + '_' + index;
                    let state = 'state0';
                    if (!(document.getElementById(id).className.toString().slice(-1) === '3')) {
                        state = 'state' + (Number(document.getElementById(id).className.toString().slice(-1)) + 1);
                    }
                    this.students()[parentIndex].studentAttendances[index].visitStatus = state.slice(-1);
                    console.log(this.students()[parentIndex]);
                    document.getElementById(id).className = state;
                },
                showToggleLaboratory: function (index, parentIndex) {
                    console.log(this.students()[parentIndex]);
                },
            };
            self.alter = {
                stringify: function () {
                    var studentPerformances = ko.mapping.toJS(self.current.students());
                    return JSON.stringify({
                        disciplinePlan: self.filter.semester().id,
                        studentPerformances: studentPerformances,
                    });
                },
                fill: function (d) {
                    let oldStudents = ko.mapping.toJS(d);
                    console.log(d);
                    oldStudents.forEach(studentInfo => {

                        if (studentInfo.studentAttendances.length > 0) {
                            self.mode(state.update);
                        }
                        else {
                            self.mode(state.create);
                            for (let i = 1; i < self.filter.semester().countLecture + 1; i++) {
                                let studentAttendance = ko.toJS(self.current.studentAttendance);
                                studentAttendance.id = i;
                                studentAttendance.student = d.student;
                                studentAttendance.disciplinePlan = self.filter.semester;
                                studentAttendance.occupationType = 'lecture';
                                studentAttendance.occupationNumber = i;
                                studentAttendance.visitStatus = 0;
                                studentInfo.studentAttendances.push(studentAttendance);
                            }

                            for (let i = 1; i < self.filter.semester().countPractical + 1; i++) {
                                let studentAttendance = ko.toJS(self.current.studentAttendance);
                                studentAttendance.id = self.filter.semester().countLecture + i + 1;
                                studentAttendance.student = d.student;
                                studentAttendance.disciplinePlan = self.filter.semester;
                                studentAttendance.occupationType = 'practical';
                                studentAttendance.occupationNumber = i;
                                studentAttendance.visitStatus = 0;
                                studentInfo.studentAttendances.push(studentAttendance);
                            }
                        }

                        if (studentInfo.studentProgresses.length > 0) {
                            self.mode(state.update);
                        }
                        else {
                            self.mode(state.create);
                            for (let i = 1; i < self.filter.semester().countLaboratory + 1; i++) {
                                let studentProgress = ko.toJS(self.current.studentProgress);
                                studentProgress.id = i;
                                studentProgress.student = d.student;
                                studentProgress.disciplinePlan = self.filter.semester;
                                studentProgress.occupationType = 'mark';
                                studentProgress.workNumber = i;
                                studentProgress.workMark = "";
                                studentInfo.studentProgresses.push(studentProgress);
                            }
                        }
                    });
                    self.current.students(oldStudents);
                    console.log(self.mode());
                },
            };
            self.filter = {

                profile: ko.observable(),
                discipline: ko.observable(),
                group: ko.observable(),
                semester: ko.observable(),

                planId: ko.observable(),

                profiles: ko.observableArray([]),
                disciplines: ko.observableArray([]),

                semesters: ko.observableArray([]),
                uniqueDisciplines: ko.observableArray([]),

                groups: ko.observableArray([]),
                uniqueDisciplinesFunction: function () {
                    let allDisciplines = ko.mapping.toJS(self.filter.disciplines());
                    ret = [];
                    allDisciplines.forEach(d => {
                        if (!ret.find(t => t.discipline === d.discipline))
                            ret.push(d);
                    });
                    console.log(ret);
                    return ret;
                },
                disciplineSemesters: function () {
                    let allDisciplines = ko.mapping.toJS(self.filter.disciplines());
                    ret = [];
                    allDisciplines.forEach(d => {
                        if (d.discipline === self.filter.discipline().discipline)
                            ret.push(d);
                    });
                    console.log(ret);
                    return ret;
                },

                set: {
                    profile: function () {
                        var id = self.settings().result_profile;
                        if (!id) return;
                        $.each(self.filter.profiles(), function (i, item) {
                            if (item.id() == id()) {
                                self.filter.profile(item);
                            }
                        });
                    },
                    group: function (id) {
                        var id = id || self.settings().result_group;
                        if (!id) return;
                        $.each(self.filter.groups(), function (i, item) {
                            if (item.id() == id()) {
                                self.filter.group(item);
                            }
                        });
                    },
                    discipline: function (id) {
                        var id = id || self.settings().result_discipline;
                        if (!id) return;
                        $.each(self.filter.uniqueDisciplines(), function (i, item) {
                            if (item.id == id()) {
                                self.filter.discipline(item);
                            }
                        });
                    },
                    semester: function (id) {
                        var id = id || self.settings().result_semester;
                        if (!id) return;
                        $.each(self.filter.semesters(), function (i, item) {
                            if (item.id == id()) {
                                self.filter.semester(item);
                            }
                        });
                    },
                },
                clear: function () {
                    self.filter.group() ? self.filter.group(null) : null;
                    self.filter.discipline() ? self.filter.discipline(null) : null;
                    self.filter.semester() ? self.filter.semester(null) : null;
                }
            };

            self.get = {
                settings: function () {
                    var json = JSON.stringify({
                        settings: [
                            "result_profile",
                            "result_discipline",
                            "result_group",
                            "result_semester"
                        ]
                    });
                    $ajaxpost({
                        url: '/api/uisettings/get',
                        data: json,
                        errors: self.errors,
                        successCallback: function (data) {
                            self.settings(data);
                            self.get.profiles();
                        },
                        errorCallback: function () {
                            self.settings(null);
                            self.get.profiles();
                        }
                    });
                },
                profiles: function () {
                    $ajaxget({
                        url: '/api/profiles',
                        errors: self.errors,
                        successCallback: function (data) {
                            self.filter.profiles(data());
                            self.settings() ? self.filter.set.profile() : null;
                        }
                    });
                },
                groups: function () {
                    $ajaxget({
                        url: '/api/profile/' + self.filter.profile().id() + '/groups',
                        errors: self.errors,
                        successCallback: function (data) {
                            self.filter.groups(data());
                            self.settings() ? self.filter.set.group() : null;
                        }
                    });
                },
                disciplines: function () {
                    if (self.filter.group()) {
                        let url = '/api/plan/discipline/show' +
                            '?studyplan=' + self.filter.group().studyplanId();
                        $ajaxpost({
                            url: url,
                            errors: self.errors,
                            data: null,
                            successCallback: function (data) {
                                self.filter.disciplines(data.data());
                                self.filter.uniqueDisciplines(self.filter.uniqueDisciplinesFunction());
                                // self.filter.disciplines(data());
                                self.settings() ? self.filter.set.discipline() : null;
                            }
                        });
                    }
                },

                performances: function () {
                    var url = '/api/performance/show' +
                        '?discipline=' + self.filter.semester().id + '&group=' + self.filter.group().id();

                    var requestOptions = {
                        url: url,
                        errors: self.errors,
                        data: null,
                        successCallback: function (data) {
                            self.alter.fill(data());
                        }
                    };
                    $ajaxpost(requestOptions);
                },

                attendance: function () {
                    self.current.students().forEach(d => {
                        var url = '/api/performance/attendances' +
                            '?discipline=' + self.filter.discipline().disciplineId + '&student=' + d.id();

                        var requestOptions = {
                            url: url,
                            errors: self.errors,
                            data: null,
                            successCallback: function (data) {
                                //  self.current.student().studentAttendances(data());

                                // console.log(self.current.student().studentAttendances());
                            }
                        };
                        $ajaxpost(requestOptions);
                    });
                },
                semesters: function () {
                    if (self.filter.discipline) {
                        self.filter.semesters(self.filter.disciplineSemesters());
                        self.settings() ? self.filter.set.semester() : null;
                    }
                },
                empty: function () {
                    self.current.studentAttendances([]);
                    self.current.studentProgresses([]);
                },
                results: function () {
                    var group = self.filter.group();
                    var discipline = self.filter.discipline;
                    var semester = self.filter.semester();

                    if (!semester) {
                        self.get.empty();
                        self.get.semesters();
                        return;
                    }

                    if (!discipline) {
                        self.get.empty();
                        self.get.disciplines();
                        return;
                    }

                    if (!group) {
                        self.get.empty();
                        self.get.groups();
                        return;
                    }

                    self.current.tableWidthLecture([]);
                    self.current.tableWidthPractical([]);
                    self.current.tableWidthLaboratory([]);

                    let retLecture = [];
                    for (let i = 1; i < semester.countLecture + 1; i++)
                        retLecture.push('ЛЕК ' + i);
                    self.current.tableWidthLecture(retLecture);

                    console.log(self.filter.semester());

                    let retPrectical = [];
                    for (let i = 1; i < semester.countPractical + 1; i++)
                        retPrectical.push('ПРЗ ' + i);
                    self.current.tableWidthPractical(retPrectical);

                    let retLaboratory = [];
                    for (let i = 1; i < semester.countLaboratory + 1; i++)
                        retLaboratory.push('ЛАБ ' + i);
                    self.current.tableWidthLaboratory(retLaboratory);

                    self.get.performances();
                },
            };
            self.post = {
                settings: function (settings) {
                    $ajaxpost({
                        url: '/api/uisettings/set',
                        errors: self.errors,
                        data: JSON.stringify({settings: settings})
                    });
                },
                performances: function () {

                    console.log(self.mode());

                    var requestOptions = {
                        url: self.mode() === state.create ? '/api/performance/create' : '/api/performance/update',
                        errors: self.errors,
                        data: self.alter.stringify(),
                        successCallback: function (data) {
                            self.mode(state.update);
                            console.log('Success');
                        }
                    };
                    $ajaxpost(requestOptions);
                },
            };

            self.get.settings();

            self.actions = {
                update: function () {
                    self.post.performances();
                    // self.current.discipline.isValid()
                    //     ? self.post.discipline()
                    //     : self.validation[$('[accept-validation]').attr('id')].open();
                },
                cancel: function () {
                    self.get.performances();
                },
            };

            //SUBSCRIPTIONS

            self.filter.profile.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_profile': self.filter.profile().id()});
                    self.get.groups();
                    self.get.disciplines();
                    return;
                }
                self.filter
                    .groups([]);
                self.post.settings({'result_profile': null});
            });
            self.filter.group.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_group': self.filter.group().id()});
                    self.get.empty();
                    self.get.disciplines();
                    self.get.semesters();
                    return;
                }
                self.get.empty();
                self.filter.uniqueDisciplines([]);
                self.post.settings({'result_group': null});
            });
            self.filter.discipline.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_discipline': self.filter.discipline().id});
                    self.get.empty();
                    console.log(self.filter.discipline());
                    self.get.semesters();
                    return;
                }
                self.filter.semesters([]);
                self.post.settings({'result_discipline': null});
            });
            self.filter.semester.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_semester': self.filter.semester().id});
                    self.get.results();
                    return;
                }
                self.get.empty();
                self.post.settings({'result_semester': null});
                self.current.tableWidthLecture([]);
                self.current.tableWidthPractical([]);
                self.current.tableWidthLaboratory([]);
            });
            return returnStandart.call(self);
        };
    };

    ko.applyBindings(performanceViewModel());
});

