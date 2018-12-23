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
                }),
                planId: ko.observable(),
                showToggleLecture: function (index, parentIndex) {
                    let id = 'toggleLecture' + parentIndex + '_' + index;
                    let state = 'state0';
                    if (!(document.getElementById(id).className.toString().slice(-1) === '3')) {
                        state = 'state' + (Number(document.getElementById(id).className.toString().slice(-1)) + 1);
                    }
                    console.log(this.students()[parentIndex]);
                    document.getElementById(id).className = state;
                },
                showTogglePractical: function (index, parentIndex) {
                    let id = 'togglePractical' + parentIndex + '_' + index;
                    let state = 'state0';
                    if (!(document.getElementById(id).className.toString().slice(-1) === '3')) {
                        state = 'state' + (Number(document.getElementById(id).className.toString().slice(-1)) + 1);
                    }
                    console.log(this.students()[parentIndex]);
                    document.getElementById(id).className = state;
                },
                showToggleLaboratory: function (student) {
                    return;
                },
                // attendancesByStudent: ko.computed(function () {
                //     var result = [],
                //         currentLetter, currentGroup;
                //     ko.utils.arrayForEach(self.contacts(), function (contact) {
                //         if (contact.name[0] !== currentLetter) {
                //             currentLetter = contact.name[0];
                //             currentGroup = {
                //                 letter: currentLetter,
                //                 contacts: []
                //             };
                //             result.push(currentGroup);
                //         }
                //         currentGroup.contacts.push(contact);
                //     });
                //     return result;
                // })
            }
            ;
            self.alter = {
                stringify: function () {
                    var studentAttendances = ko.mapping.toJS(self.current.studentAttendances());
                    var studentProgresses = ko.mapping.toJS(self.current.studentProgresses());
                    // console.log(self.filter.group().id());
                    // console.log(self.filter.semester().id);
                    // if (self.mode() === state.create) delete discipline.id;
                    return JSON.stringify({
                        disciplinePlan: self.filter.semester().id,
                        studentAttendances: studentAttendances,
                        studentProgresses: studentProgresses,
                    });
                },
                fill: function (d) {
                    let oldStudents = ko.mapping.toJS(d);
                    oldStudents.forEach(studentInfo => {

                        if (studentInfo.studentAttendances.length > 0) {
                            self.mode(state.update);
                            //  self.current.studentAttendances.push(d.studentProgresses);
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
                                studentAttendance.visitStatus = 1;
                                studentInfo.studentAttendances.push(studentAttendance);
                                // self.current.studentAttendances.push(studentAttendance);
                            }

                            for (let i = 1; i < self.filter.semester().countPractical + 1; i++) {
                                let studentAttendance = ko.toJS(self.current.studentAttendance);
                                studentAttendance.id = self.filter.semester().countLecture + i + 1;
                                studentAttendance.student = d.student;
                                studentAttendance.disciplinePlan = self.filter.semester;
                                studentAttendance.occupationType = 'practical';
                                studentAttendance.occupationNumber = i;
                                studentAttendance.visitStatus = 1;
                                studentInfo.studentAttendances.push(studentAttendance);
                                //self.current.studentAttendances.push(studentAttendance);
                            }
                        }


                        if (studentInfo.studentProgresses.length > 0) {
                            self.mode(state.update);
                            //self.current.studentProgresses.push(d.studentProgresses);
                            //todo присвоить students.progresses
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
                                studentProgress.workMark = "100";
                                studentInfo.studentProgresses.push(studentProgress);
                                //self.current.studentProgresses.push(studentProgress);
                            }
                        }
                    });

                    self.current.students(oldStudents);
                    console.log(self.current.students());

                    console.log(self.mode());

                    // ko.mapping.fromJS(d, {}, self.current.students());
                },
                empty: function () {
                    let oldStudents = ko.mapping.toJS(data());
                    let students = [];

                    self.get.empty();
                    console.log(oldStudents);
                    count = 0;
                    oldStudents.forEach(d => {
                        students.push(d.student);
                        if (d.studentAttendances.length > 0) {
                            self.current.studentProgresses.push(d.studentProgresses);
                        }
                        else {
                            console.log(self.filter.semester().countLecture);
                            for (let i = 1; i < self.filter.semester().countLecture + 1; i++) {
                                let studentAttendance = ko.toJS(self.current.studentAttendance);
                                studentAttendance.id = i;
                                studentAttendance.student = d.student;
                                studentAttendance.disciplinePlan = self.filter.semester;
                                studentAttendance.occupationType = 'lecture';
                                studentAttendance.occupationNumber = i;
                                studentAttendance.visitStatus = 0;
                                self.current.studentAttendances.push(studentAttendance);
                            }

                            for (let i = 1; i < self.filter.semester().countPractical + 1; i++) {
                                let studentAttendance = ko.toJS(self.current.studentAttendance);
                                studentAttendance.id = self.filter.semester().countLecture + i + 1;
                                studentAttendance.student = d.student;
                                studentAttendance.disciplinePlan = self.filter.semester;
                                studentAttendance.occupationType = 'practical';
                                studentAttendance.occupationNumber = i;
                                studentAttendance.visitStatus = 0;
                                self.current.studentAttendances.push(studentAttendance);
                            }

                            for (let i = 1; i < self.filter.semester().countLaboratory + 1; i++) {
                                let studentProgress = ko.toJS(self.current.studentProgress);
                                studentProgress.id = i;
                                studentProgress.student = d.student;
                                studentProgress.disciplinePlan = self.filter.semester;
                                studentProgress.occupationType = 'mark';
                                studentProgress.workNumber = i;
                                studentProgress.workMark = "";
                                self.current.studentProgresses.push(studentProgress);
                            }

                            console.log(self.current.studentAttendances());
                            console.log(self.current.studentProgresses());
                        }
                    });
                    self.current.students(students);

                    // на кнопку Сохранить
                    // self.post.performances();
                }
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
                        '?discipline=' + self.filter.discipline().disciplineId + '&group=' + self.filter.group().id();

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
                    // self.filter.discipline = self.filter.discipline();

                    let ret = [];
                    for (let i = 1; i < semester.countLecture + 1; i++)
                        ret.push('ЛЕК ' + i);
                    self.current.tableWidthLecture(ret);

                    console.log(self.filter.semester());

                    let ret2 = [];
                    for (let i = 1; i < semester.countPractical + 1; i++)
                        ret2.push('ПРЗ ' + i);
                    self.current.tableWidthPractical(ret2);

                    let ret3 = [];
                    for (let i = 1; i < semester.countLaboratory + 1; i++)
                        ret3.push('ЛАБ ' + i);
                    self.current.tableWidthLaboratory(ret3);

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
                    // var url = '/api/performance/show' +
                    //     '?discipline=' + self.filter.discipline().disciplineId + '&group=' + self.filter.group().id();
                    self.mode(state.create);
                    y = self.alter.stringify();
                    console.log(y);

                    var requestOptions = {
                        url: self.mode() === state.create ? '/api/performance/create' : '/api/performance/update',
                        errors: self.errors,
                        data: self.alter.stringify(),
                        successCallback: function (data) {
                            self.mode(state.none);
                            // self.alter.empty();
                            // self.initial.selection(null);
                            // self.get.disciplines();

                            let oldStudents = ko.mapping.toJS(data());
                            let students = [];

                            console.log(oldStudents);
                            oldStudents.forEach(d => {
                                students.push(d.student);
                                self.current.studentAttendances.push(d.studentAttendances);
                                self.current.studentProgresses.push(d.studentProgresses);
                            });

                            console.log(self.current.studentAttendances()[0]);
                            self.current.students(students);
                        }
                    };
                    $ajaxpost(requestOptions);
                },
            };

            self.get.settings();

            //SUBSCRIPTIONS

            self.filter.profile.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_profile': self.filter.profile().id()});
                    self.get.groups();
                    self.get.disciplines();
                    // self.get.empty();
                    return;
                }
                self.filter
                    .groups([]);
                self.post.settings({'result_profile': null});
                // self.get.empty();
            });
            self.filter.group.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_group': self.filter.group().id()});
                    self.get.empty();
                    self.get.disciplines();
                    self.get.semesters();
                    // self.get.results();
                    return;
                }
                self.get.empty();
                self.filter.uniqueDisciplines([]);
                self.post.settings({'result_group': null});
                // self.get.results();
            });
            self.filter.discipline.subscribe(function (value) {
                if (value) {
                    self.post.settings({'result_discipline': self.filter.discipline().id});
                    self.get.empty();
                    console.log(self.filter.discipline());
                    self.get.semesters();
                    // self.get.results();
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
    self.actions = {
        update: function () {
            self.post.performances();
            // self.current.discipline.isValid()
            //     ? self.post.discipline()
            //     : self.validation[$('[accept-validation]').attr('id')].open();
        },
        cancel: function () {
            y = 'нет';
            // if (self.mode() === state.create) {
            //     self.alter.empty();
            //     self.mode(state.none);
            // }
            // self.mode(state.info);
        },
    };

    ko.applyBindings(performanceViewModel());
});

