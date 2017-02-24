$(document).ready(function(){

    var themeViewModel = function(){
        return new function(){
            var self = this;

            self.page = ko.observable(menu.admin.results);
            self.theme = ko.observable({});
            self.validation = {};
            self.events = new validationEvents(self.validation);
            self.errors = errors();

            self.current = {
                result: ko.observable(),
                results: ko.observableArray([]),
                test: ko.observable(),
                attempts: ko.observable(),
                answers: ko.observableArray([]),
                answer: ko.observable({
                    id: ko.observable(0),
                    answer: ko.observable(),
                    question: ko.observable({
                        text: ko.observable()
                    }),
                    rightPercentage: ko.observable()
                }),
                mark: {
                    isInput: ko.observable(false),
                    value: ko.validatedObservable('Оценить').extend({
                        required: true,
                        digit: true,
                        min: 0,
                        max: 100
                    })
                }
            };
            self.actions = {
                answer: {
                    show: function(data){
                        self.current.answer().id() === data.id() ?
                            self.current.answer().id(0) :
                            self.alter.fill.answer(data);
                        self.current.mark.isInput(false);
                    },

                    fit: {
                        question: function(data){
                            var q = data.question.text();
                            return commonHelper.shortenText(q, 100);
                        }
                    }
                },
                mark: {
                    edit: function(data){
                        self.current.mark.isInput(true);
                        self.current.mark.value('');
                        if (data.rightPercentage()){
                            self.current.mark.value(data.rightPercentage());
                        }
                        commonHelper.buildValidationList(self.validation);
                    },
                    approve: function(data){
                        var value = self.current.mark.value;
                        if (!value.isValid()) return;
                        data.rightPercentage(value());
                        self.post.mark(data.id(), value());
                        self.current.mark.isInput(false);
                        value('Оценить');
                    },
                    cancel: function(){
                        self.current.mark.isInput(false);
                        self.current.mark.value('Оценить');
                    }
                },
                result:{
                    date: function(){
                        var date = self.current.result().dateTime.date;
                        date(commonHelper.parseDate(date()));
                    },
                    fit: function(){
                        self.actions.result.date();
                    }
                },
                results: {
                    view: function(){
                        commonHelper.modal.open('#attempts-modal');
                    },
                    select: function(data){
                        commonHelper.modal.close('#attempts-modal');
                        window.location.href = '/admin/result/' + data.id();
                    }
                }
            };

            self.alter = {
                fill: {
                    answer: function(d){
                        self.current.answer()
                            .id(d.id())
                            .answer(d.answer())
                            .question(d.question)
                            .rightPercentage(d.rightPercentage());
                    }
                }
            };

            self.get = {
                result: function(){
                    var url = window.location.href;
                    var id = +url.substr(url.lastIndexOf('/')+1);

                    $ajaxget({
                        url: '/api/results/' + id,
                        errors: self.errors,
                        successCallback: function(data){
                            self.current.answers(data.answers());
                            self.current.result(data.testResult);
                            self.current.attempts(data.attemptsAllowed());
                            self.current.test(data.test);

                            self.actions.result.fit();
                            self.get.results();
                        }
                    });
                },
                results: function(){
                    var result = self.current.result();
                    var user = result.user.id();
                    var test = result.testId();

                    $ajaxget({
                        url: '/api/results/getByUserAndTest?userId='+ user + '&testId=' + test,
                        errors: self.errors,
                        successCallback: function(data){
                            self.current.results(data());
                            commonHelper.tooltip({selector: '.tagged', side: 'left'})
                        }
                    });
                }
            };
            self.post = {
                mark: function(id, mark){
                    $ajaxpost({
                        url: '/api/results/setMark',
                        data: JSON.stringify({answerId: id, mark: mark}),
                        errors: self.errors,
                        successCallback: function(){
                            self.get.result();
                        }
                    });
                }
            };

            self.get.result();


            return {
                page: self.page,
                errors: self.errors,
                actions: self.actions,
                current: self.current,
                mode: self.mode,
                filter: self.filter,
                events: self.events
            };
        };
    };

    ko.applyBindings(themeViewModel());
});
